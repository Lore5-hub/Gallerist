<?php

class CAdmin {

    /**
     * Metodo privato di controllo (Il "Buttafuori").
     * Verifica se l'utente è loggato ed è un amministratore.
     * @return bool
     */
    private static function checkAdmin(): bool {
        $sessione = USession::getInstance();
        
        // 1. Controlliamo se esiste un utente in sessione
        if (!$sessione->esisteValore('utente_loggato')) {
            return false;
        }
        
        $utente = $sessione->getValore('utente_loggato');
        
        // 2. Verifichiamo se l'utente ha il ruolo di admin
        // NOTA: Assicurati che la tua entità EUtente abbia il metodo getRuolo() 
        // o che restituisca 'admin'
        if ($utente instanceof EUtente && $utente->getRuolo() === 'Amministratore') {
            return true;
        }
        
        return false;
    }

    /**
     * Mostra la Dashboard principale dell'Amministratore
     * Risponde all'URL: /Gallerist/Admin/dashboard
     */
    public function dashboard() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/Utente/login');
        exit;
    }
 $sessione  = USession::getInstance();
$verifica  = $sessione->getValore('flash_verifica');
$sessione->eliminaValore('flash_verifica');
    // ✅ Control parla SOLO con FPersistentManager
    $artisitInAttesa = FPersistentManager::getArtistiInAttesa();
    $artistiAttivi   = FPersistentManager::getArtistiAttivi();
    $utentiStandard  = FPersistentManager::getUtentiStandard();
    $segnalazioniList = FPersistentManager::getSegnalazioniAperte();
    $dashboard = [
        'utenti_totali'       => count($utentiStandard) + count($artistiAttivi),
        'utenti_perc'         => 5,   // mock
        'utenti_attesa'       => count($artisitInAttesa),
        'artisti_attivi'      => count($artistiAttivi),
        'artisti_perc'        => 8,   // mock
        'segnalazioni_aperte' => count($segnalazioniList),
        'segnalazioni_perc'   => 3,   // mock
        'commenti_segnalati'  => 0,   // mock
        'commenti_perc'       => 2,   // mock
    ];
    $segnalazioniArray = [];
foreach ($segnalazioniList as $seg) {
    $segnalazioniArray[] = [
        'id'                  => $seg->getId(),
        'tipo'                => $seg->getTipoTarget(),
        'contenuto'           => $seg->getMotivo(),
        'autore_segnalazione' => $seg->getIdSegnalatore(), // id, non nickname — da migliorare
        'data'                => $seg->getDataSegnalazione()->format('Y-m-d'),
        'stato'               => 'Aperta',
    ];
}
    // Converte gli oggetti EArtista in array per il {foreach} di Smarty
    $utentiInAttesaArray = [];
    foreach ($artisitInAttesa as $artista) {
        $utentiInAttesaArray[] = [
            'id'                 => $artista->getId(),
            'nickname'           => $artista->getNickname(),
            'data_registrazione' => $artista->getDataDiNascita()->format('Y-m-d'),
        ];
    }

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('dashboard',        $dashboard);
    $vAdmin->smarty->assign('utenti_in_attesa', $utentiInAttesaArray);
    $vAdmin->smarty->assign('categorie',        []);   // da implementare
    $vAdmin->smarty->assign('segnalazioni', $segnalazioniArray);
    $vAdmin->smarty->assign('bannati',          []);   // da implementare
    $vAdmin->smarty->assign('nome_admin',       USession::getInstance()->getValore('utente_loggato')->getNickname());
    $vAdmin->smarty->assign('verifica', $_GET['verifica'] ?? null);
    $vAdmin->smarty->assign('verifica', $verifica);
    $vAdmin->smarty->display('AdminDashboard.tpl');
}

    /**
     * Esempio di altra funzione protetta: Gestione degli Utenti
     * Risponde all'URL: /Gallerist/Admin/gestioneUtenti
     */
    public function gestioneUtenti() {
        if (!self::checkAdmin()) {
            header('Location: /Gallerist/Utente/login');
            exit;
        }

        // Codice per caricare tutti gli utenti dal DB e mostrarli all'admin...
    }
    /**
 * Mostra le statistiche della piattaforma.
 * Risponde all'URL: /Gallerist/Admin/statistiche
 */
public function statistiche() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/Utente/login');
        exit;
    }

    // Periodo dal selettore nel template (default 30 giorni)
    $giorni = isset($_GET['periodo']) ? (int)$_GET['periodo'] : 30;
    if (!in_array($giorni, [7, 30, 90, 365])) {
        $giorni = 30;
    }

    $db         = FDataBase::getInstance();
    $dataInizio = date('Y-m-d H:i:s', strtotime("-{$giorni} days"));
    $fattore    = $giorni / 30; // usato per scalare i dati mock

    // ---------------------------------------------------------------
    // DATI REALI DAL DB
    // ---------------------------------------------------------------

    // Totale utenti non admin (manca data_registrazione in tabella → count totale)
    $resUtenti = $db->queryDB(
        "SELECT COUNT(*) as totale FROM utente WHERE ruolo != 'Amministratore'",
        []
    );
    $totaleRegistrazioni = $resUtenti ? (int)$resUtenti[0]['totale'] : 0;

    // Opere totali
    $resOpere = $db->queryDB("SELECT COUNT(*) as totale FROM opera", []);
    $totaleOpere = $resOpere ? (int)$resOpere[0]['totale'] : 0;

    // Commenti nel periodo
    $resCommenti = $db->queryDB(
        "SELECT COUNT(*) as totale FROM commento WHERE data >= :data",
        [':data' => $dataInizio]
    );
    $totaleCommenti = $resCommenti ? (int)$resCommenti[0]['totale'] : 0;

    // Ordini e guadagni nel periodo
    $resOrdini = $db->queryDB(
        "SELECT COUNT(*) as totale, COALESCE(SUM(prezzoVendita), 0) as guadagni 
         FROM ordine WHERE dataOrdine >= :data",
        [':data' => $dataInizio]
    );
    $totaleMovimenti = $resOrdini ? (int)$resOrdini[0]['totale']    : 0;
    $guadagni        = $resOrdini ? (float)$resOrdini[0]['guadagni'] : 0.0;

    // ---------------------------------------------------------------
    // DATI MOCK per metriche analytics non tracciate nel DB
    // (visite, pageviews, tempo medio — non abbiamo una tabella dedicata)
    // ---------------------------------------------------------------
    $visiteTotali = (int)(1240 * $fattore);
    $visPagina    = (int)(4830 * $fattore);

    // ---------------------------------------------------------------
    // ARRAY $stats → variabile Smarty usata nel template
    // ---------------------------------------------------------------
    $stats = [
        // KPI cards
        'visite_totali'   => number_format($visiteTotali, 0, ',', '.'),
        'visite_perc'     => 12,   // mock: % vs periodo precedente
        'registrazioni'   => number_format($totaleRegistrazioni, 0, ',', '.'),
        'reg_perc'        => 8,
        'vis_pagina'      => number_format($visPagina, 0, ',', '.'),
        'vis_pag_perc'    => 5,
        'tempo_medio'     => '3m 42s',  // mock: non tracciato
        'tempo_perc'      => 3,
        'movimenti'       => number_format($totaleMovimenti, 0, ',', '.'),
        'mov_perc'        => 15,
        'guadagni'        => $guadagni,
        'guad_perc'       => 18,
        // Azioni principali (colonna destra)
        'azioni_reg'      => $totaleRegistrazioni,
        'azioni_opere'    => $totaleOpere,
        'azioni_commenti' => $totaleCommenti,
    ];

    // ---------------------------------------------------------------
    // TOP PAGINE (mock: nessuna tabella di page tracking)
    // ---------------------------------------------------------------
    $topPagine = [
        ['nome' => 'Catalogo',        'url' => '/Gallerist/catalogo/esploraCatalogo', 'visualizzazioni' => (int)(980 * $fattore)],
        ['nome' => 'Home',            'url' => '/Gallerist/',                          'visualizzazioni' => (int)(750 * $fattore)],
        ['nome' => 'Login',           'url' => '/Gallerist/Utente/login',              'visualizzazioni' => (int)(430 * $fattore)],
        ['nome' => 'Registrazione',   'url' => '/Gallerist/Utente/registrazione',      'visualizzazioni' => (int)(310 * $fattore)],
        ['nome' => 'Dettaglio Opera', 'url' => '/Gallerist/catalogo/dettaglio',        'visualizzazioni' => (int)(280 * $fattore)],
    ];

    // ---------------------------------------------------------------
    // DATI GRAFICI per Chart.js (passati come JSON al template)
    // Visite e Pagine: mock   |   Guadagni: reali dal DB
    // ---------------------------------------------------------------
    $labelGrafici = [];
    $datiVisite   = [];
    $datiPagine   = [];
    $datiGuadagni = [];

    // Step dinamico in base al periodo (giornaliero, settimanale, ecc.)
    $step = match(true) {
        $giorni <= 7  => 1,
        $giorni <= 30 => 7,
        $giorni <= 90 => 14,
        default       => 30,
    };

    for ($i = $giorni; $i >= 0; $i -= $step) {
        $labelGrafici[] = date('d/m', strtotime("-{$i} days"));
        $datiVisite[]   = rand((int)(30 * $fattore), (int)(80 * $fattore));
        $datiPagine[]   = rand((int)(100 * $fattore), (int)(250 * $fattore));

        // Guadagni reali per ogni intervallo
        $dal  = date('Y-m-d', strtotime("-{$i} days"));
        $al   = date('Y-m-d', strtotime('-' . max(0, $i - $step) . ' days'));
        $resG = $db->queryDB(
            "SELECT COALESCE(SUM(prezzoVendita), 0) as tot 
             FROM ordine WHERE dataOrdine BETWEEN :dal AND :al",
            [':dal' => $dal, ':al' => $al]
        );
        $datiGuadagni[] = $resG ? round((float)$resG[0]['tot'], 2) : 0;
    }

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('stats',         $stats);
    $vAdmin->smarty->assign('top_pagine',    $topPagine);
    $vAdmin->smarty->assign('giorni',        $giorni);
    $vAdmin->smarty->assign('label_grafici', json_encode($labelGrafici));
    $vAdmin->smarty->assign('dati_visite',   json_encode($datiVisite));
    $vAdmin->smarty->assign('dati_pagine',   json_encode($datiPagine));
    $vAdmin->smarty->assign('dati_guadagni', json_encode($datiGuadagni));
    $vAdmin->smarty->display('AdminStatistiche.tpl');
}
/**
 * Valida un artista in attesa di approvazione.
 * Risponde all'URL: /Gallerist/Admin/verificaArtista?id=X
 */
public function verificaArtista() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/Utente/login');
        exit;
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id === 0) {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    // Carica l'artista tramite FPersistentManager
    $artista = FPersistentManager::load('EArtista', 'id', $id);

    // Sicurezza: verifica che esista e sia effettivamente in attesa
    if (!$artista instanceof EArtista || $artista->getStatoValidazione() !== 'IN_ATTESA') {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    // Aggiorna stato_validazione ad APPROVATO
    // FPersistentManager::load usa FArtista::loadByField che fa JOIN su idUtente
    // quindi la PK per la tabella artista è idUtente
    $ok = FPersistentManager::update('EArtista', 'stato_validazione', 'APPROVATO', 'idUtente', $id);

    if ($ok) {
        // Aggiorna anche stato_account in utente → da 'attivo' rimane attivo,
        // ma se avessi messo uno stato 'in_attesa' anche lì va aggiornato
        FPersistentManager::update('EUtente', 'stato_account', EUtente::STATO_ATTIVO, 'id', $id);
    }

    // Torna alla dashboard con un parametro di feedback
   $sessione = USession::getInstance();
$sessione->setValue('flash_verifica', $ok ? 'successo' : 'errore');
header('Location: /Gallerist/Admin/dashboard');
exit;
}
/**
 * Mostra la pagina di validazione di un artista.
 * Risponde all'URL: /Gallerist/Admin/mostraValidazione?id=X
 */
public function mostraValidazione() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id === 0) {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    $artista = FPersistentManager::load('EArtista', 'id', $id);
    if (!$artista instanceof EArtista) {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    // Costruisce l'array che il template si aspetta
    $utente = [
        'id'                 => $artista->getId(),
        'nome'               => $artista->getNome(),
        'cognome'            => $artista->getCognome(),
        'email'              => $artista->getEmail(),
        'nickname'           => $artista->getNickname(),
        'telefono'           => $artista->getTelefono(),
        'indirizzo'          => $artista->getIndirizzo(),
        'data_nascita'       => $artista->getDataDiNascita()->format('Y-m-d'),
        'data_registrazione' => $artista->getDataDiNascita()->format('Y-m-d'), // non abbiamo data reg separata
        'biografia'          => $artista->getBiografia(),
        'stile_artistico'    => $artista->getStileArtistico(),
        'localita'           => $artista->getIndirizzo(),
        'carta_identita'     => $artista->getCartaIdentita(),
        'data_documento'     => date('Y-m-d'), // mock
        'note_admin'         => '',
    ];

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('utente',          $utente);
    $vAdmin->smarty->assign('opere_portfolio', []); // mock — nessun portfolio caricato
    $vAdmin->smarty->display('AdminValidazione.tpl');
}
/**
 * Mostra il dettaglio di una segnalazione.
 * Risponde all'URL: /Gallerist/Admin/mostraSegnalazione?id=X
 */
public function mostraSegnalazione() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($id === 0) {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    $seg = FPersistentManager::load('ESegnalazione', 'id', $id);
    if (!$seg instanceof ESegnalazione) {
        header('Location: /Gallerist/Admin/dashboard');
        exit;
    }

    // Carica l'utente segnalato
    $utenteSegnalato = FPersistentManager::load('EUtente', 'id', $seg->getIdTarget());
    
    // Carica l'utente segnalante per mostrare il nickname
    $utenteSegnalante = FPersistentManager::load('EUtente', 'id', $seg->getIdSegnalatore());

    $segnalazione = [
        'id'                  => $seg->getId(),
        'tipo_oggetto'        => $seg->getTipoTarget(),
        'autore_segnalazione' => $utenteSegnalante ? $utenteSegnalante->getNickname() : $seg->getIdSegnalatore(),
        'data_invio'          => $seg->getDataSegnalazione()->format('Y-m-d H:i:s'),
        'stato'               => $seg->getStato()->getNomeStato(),
        'motivo_principale'   => $seg->getMotivo(),
        'dettagli_aggiuntivi' => $seg->getNotaOpzionale(),
        'titolo_opera'        => '',   // mock
        'testo_incriminato'   => '',   // mock
        'url_anteprima_opera' => '/Gallerist/img/default_opera.png',
        'id_opera'            => 0,    // mock
        'categoria_opera'     => '',   // mock
    ];

    $autoreContenuto = [
        'id'                    => $utenteSegnalato ? $utenteSegnalato->getId() : 0,
        'nickname'              => $utenteSegnalato ? $utenteSegnalato->getNickname() : 'N/D',
        'data_registrazione'    => $utenteSegnalato ? $utenteSegnalato->getDataDiNascita()->format('Y-m-d') : '',
        'stato'                 => $utenteSegnalato ? $utenteSegnalato->getStatoAccount() : '',
        'segnalazioni_ricevute' => 0,  // mock
        'commenti_pubblicati'   => 0,  // mock
    ];

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('segnalazione',               $segnalazione);
    $vAdmin->smarty->assign('autore_contenuto',           $autoreContenuto);
    $vAdmin->smarty->assign('storico_segnalazioni_utente', []);
    $vAdmin->smarty->display('AdminSegnalazioni.tpl');
}
}