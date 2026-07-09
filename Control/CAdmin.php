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
$sessione->setValue('flash_moderazione', $_GET['moderazione'] ?? null);

    // ✅ Control parla SOLO con FPersistentManager
    $artisitInAttesa = FPersistentManager::getArtistiInAttesa();
    $artistiAttivi   = FPersistentManager::getArtistiAttivi();
    $utentiStandard  = FPersistentManager::getUtentiStandard();
    $segnalazioniList = FPersistentManager::getSegnalazioniAperte();

    $db = FDataBase::getInstance();
$giorni = 30; // periodo di riferimento
$dataInizio = date('Y-m-d H:i:s', strtotime("-{$giorni} days"));
$dataPrecInizio = date('Y-m-d H:i:s', strtotime("-" . ($giorni * 2) . " days"));

// Helper percentuale
$calcPerc = function(int $attuale, int $precedente): int {
    if ($precedente === 0) return $attuale > 0 ? 100 : 0;
    return (int)round(($attuale - $precedente) / $precedente * 100);
};

// Utenti periodo attuale e precedente
$resUtentiAtt = $db->queryDB(
    "SELECT COUNT(*) as tot FROM utente WHERE ruolo != 'Amministratore' AND data_registrazione >= :data",
    [':data' => $dataInizio]
);
$resUtentiPrec = $db->queryDB(
    "SELECT COUNT(*) as tot FROM utente WHERE ruolo != 'Amministratore' AND data_registrazione >= :dal AND data_registrazione < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataInizio]
);
$utentiAtt  = $resUtentiAtt  ? (int)$resUtentiAtt[0]['tot']  : 0;
$utentiPrec = $resUtentiPrec ? (int)$resUtentiPrec[0]['tot'] : 0;

// Artisti periodo attuale e precedente
$resArtAtt = $db->queryDB(
    "SELECT COUNT(*) as tot FROM artista a INNER JOIN utente u ON u.id = a.idUtente WHERE a.stato_validazione = 'APPROVATO' AND u.data_registrazione >= :data",
    [':data' => $dataInizio]
);
$resArtPrec = $db->queryDB(
    "SELECT COUNT(*) as tot FROM artista a INNER JOIN utente u ON u.id = a.idUtente WHERE a.stato_validazione = 'APPROVATO' AND u.data_registrazione >= :dal AND u.data_registrazione < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataInizio]
);
$artAtt  = $resArtAtt  ? (int)$resArtAtt[0]['tot']  : 0;
$artPrec = $resArtPrec ? (int)$resArtPrec[0]['tot'] : 0;

// Segnalazioni periodo attuale e precedente
$resSegnAtt = $db->queryDB(
    "SELECT COUNT(*) as tot FROM segnalazione WHERE dataSegnalazione >= :data",
    [':data' => $dataInizio]
);
$resSegnPrec = $db->queryDB(
    "SELECT COUNT(*) as tot FROM segnalazione WHERE dataSegnalazione >= :dal AND dataSegnalazione < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataInizio]
);
$segnAtt  = $resSegnAtt  ? (int)$resSegnAtt[0]['tot']  : 0;
$segnPrec = $resSegnPrec ? (int)$resSegnPrec[0]['tot'] : 0;

// Commenti segnalati
$resCommSegnalati = $db->queryDB(
    "SELECT COUNT(*) as tot FROM segnalazione WHERE tipoOggetto = 'Commento'",
    []
);
$commentiSegnalati = $resCommSegnalati ? (int)$resCommSegnalati[0]['tot'] : 0;
    $dashboard = [
    'utenti_totali'       => count($utentiStandard) + count($artistiAttivi),
    'utenti_perc'         => $calcPerc($utentiAtt, $utentiPrec),   // ← reale
    'utenti_attesa'       => count($artisitInAttesa),
    'artisti_attivi'      => count($artistiAttivi),
    'artisti_perc'        => $calcPerc($artAtt, $artPrec),         // ← reale
    'segnalazioni_aperte' => count($segnalazioniList),
    'segnalazioni_perc'   => $calcPerc($segnAtt, $segnPrec),       // ← reale
    'commenti_segnalati'  => $commentiSegnalati,                   // ← reale
    'commenti_perc'       => 0,                                    // mock — difficile calcolare
];
    $segnalazioniArray = [];
foreach ($segnalazioniList as $seg) {
    $segnalante = FPersistentManager::load('EUtente', 'id', $seg->getIdSegnalatore());
    $segnalazioniArray[] = [
        'id'                  => $seg->getId(),
        'tipo'                => $seg->getTipoTarget(),
        'contenuto'           => $seg->getMotivo(),
        'autore_segnalazione' => $segnalante ? '@' . $segnalante->getNickname() : '#' . $seg->getIdSegnalatore(),
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
            'data_registrazione' => $artista->getDataRegistrazione()->format('Y-m-d'),
        ];
    }
    $provvedimenti = FPersistentManager::getProvvedimentiAttivi();
    $bannatiArray = [];
foreach ($provvedimenti as $prov) {
    $bannatiArray[] = [
        'utente' => $prov['nickname'],
        'motivo' => $prov['motivo'],
        'tipo'   => $prov['tipoBan'],
        'inizio' => $prov['dataInizio'],
        'fine'   => $prov['dataFine'],
    ];
}
    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('dashboard',        $dashboard);
    $vAdmin->smarty->assign('utenti_in_attesa', $utentiInAttesaArray);
    $vAdmin->smarty->assign('bannati',          $bannatiArray);
    $categorie = FPersistentManager::getCategorieTutte();

    $vAdmin->smarty->assign('segnalazioni', $segnalazioniArray);
    $vAdmin->smarty->assign('nome_admin',       USession::getInstance()->getValore('utente_loggato')->getNickname());
    $vAdmin->smarty->assign('verifica', $_GET['verifica'] ?? null);
    $vAdmin->smarty->assign('verifica', $verifica);
    $vAdmin->smarty->assign('moderazione', $_GET['moderazione'] ?? null);
    $vAdmin->smarty->assign('categorie', $categorie);
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

    $giorni = isset($_GET['periodo']) ? (int)$_GET['periodo'] : 30;
    if (!in_array($giorni, [7, 30, 90, 365])) {
        $giorni = 30;
    }

    $db         = FDataBase::getInstance();
    $dataInizio = date('Y-m-d H:i:s', strtotime("-{$giorni} days"));
    $dataPrecInizio = date('Y-m-d H:i:s', strtotime("-" . ($giorni * 2) . " days"));
$dataPrecFine   = $dataInizio;

// Helper per calcolare percentuale variazione
$calcPerc = function(int $attuale, int $precedente): int {
    if ($precedente === 0) return $attuale > 0 ? 100 : 0;
    return (int)round(($attuale - $precedente) / $precedente * 100);
};


    // Totale utenti non admin
    $resUtenti = $db->queryDB(
    "SELECT COUNT(*) as totale FROM utente 
     WHERE ruolo != 'Amministratore' AND data_registrazione >= :data",
    [':data' => $dataInizio]
);
$totaleRegistrazioni = $resUtenti ? (int)$resUtenti[0]['totale'] : 0;
$resUtentiPrec = $db->queryDB(
    "SELECT COUNT(*) as totale FROM utente 
     WHERE ruolo != 'Amministratore' 
     AND data_registrazione >= :dal AND data_registrazione < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$totaleRegistrazioniPrec = $resUtentiPrec ? (int)$resUtentiPrec[0]['totale'] : 0;

    // Opere totali
    $resOpere = $db->queryDB("SELECT COUNT(*) as totale FROM opera", []);
    $totaleOpere = $resOpere ? (int)$resOpere[0]['totale'] : 0;

    // Commenti nel periodo — colonna corretta: dataPubblicazione
    $resCommenti = $db->queryDB(
    "SELECT COUNT(*) as totale FROM commento WHERE dataPubblicazione >= :data",
    [':data' => $dataInizio]
);
$totaleCommenti = $resCommenti ? (int)$resCommenti[0]['totale'] : 0;

// Commenti periodo precedente
$resCommentiPrec = $db->queryDB(
    "SELECT COUNT(*) as totale FROM commento 
     WHERE dataPubblicazione >= :dal AND dataPubblicazione < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$totaleCommentiPrec = $resCommentiPrec ? (int)$resCommentiPrec[0]['totale'] : 0;

    // Ordini nel periodo — colonna corretta: data
    $resOrdini = $db->queryDB(
    "SELECT COUNT(*) as totale FROM ordine WHERE data >= :data",
    [':data' => $dataInizio]
);
$totaleMovimenti = $resOrdini ? (int)$resOrdini[0]['totale'] : 0;

// Ordini periodo precedente
$resOrdiniPrec = $db->queryDB(
    "SELECT COUNT(*) as totale FROM ordine 
     WHERE data >= :dal AND data < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$totaleMovimentiPrec = $resOrdiniPrec ? (int)$resOrdiniPrec[0]['totale'] : 0;


    // Guadagni reali — 10% commissione su ogni opera venduta nel periodo
    $resGuadagni = $db->queryDB(
    "SELECT COALESCE(SUM(o.prezzo * 0.10), 0) as guadagni
     FROM ordine ord
     INNER JOIN opera o ON o.id = ord.idOpera
     WHERE ord.data >= :data",
    [':data' => $dataInizio]
);
$guadagni = $resGuadagni ? (float)$resGuadagni[0]['guadagni'] : 0.0;

// Guadagni periodo precedente
$resGuadagniPrec = $db->queryDB(
    "SELECT COALESCE(SUM(o.prezzo * 0.10), 0) as guadagni
     FROM ordine ord
     INNER JOIN opera o ON o.id = ord.idOpera
     WHERE ord.data >= :dal AND ord.data < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$guadagniPrec = $resGuadagniPrec ? (float)$resGuadagniPrec[0]['guadagni'] : 0.0;

    // Visite reali dalla tabella visita
    $resVisite = $db->queryDB(
    "SELECT COUNT(*) as pageviews, COUNT(DISTINCT sessione) as visite 
     FROM visita WHERE data >= :data",
    [':data' => date('Y-m-d', strtotime("-{$giorni} days")) . ' 00:00:00']
);
$visiteTotali = $resVisite ? (int)$resVisite[0]['visite']    : 0;
$visPagina    = $resVisite ? (int)$resVisite[0]['pageviews'] : 0;

// Visite periodo precedente
$resVisitePrec = $db->queryDB(
    "SELECT COUNT(*) as pageviews, COUNT(DISTINCT sessione) as visite 
     FROM visita WHERE data >= :dal AND data < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$visiteTotaliPrec = $resVisitePrec ? (int)$resVisitePrec[0]['visite']    : 0;
$visPaginaPrec    = $resVisitePrec ? (int)$resVisitePrec[0]['pageviews'] : 0;

    // Top pagine reali dalla tabella visita
    $resTopPagine = $db->queryDB(
        "SELECT pagina, COUNT(*) as visualizzazioni 
         FROM visita 
         WHERE data >= :data
         GROUP BY pagina 
         ORDER BY visualizzazioni DESC 
         LIMIT 5",
        [':data' => $dataInizio]
    );

    $topPagine = [];
    foreach ($resTopPagine ?? [] as $row) {
        $topPagine[] = [
            'nome'            => $row['pagina'],
            'url'             => '/Gallerist' . $row['pagina'],
            'visualizzazioni' => $row['visualizzazioni'],
        ];
    }
$resVendute = $db->queryDB(
    "SELECT COUNT(*) as totale FROM ordine WHERE data >= :data",
    [':data' => $dataInizio]
);
$opereVendute = $resVendute ? (int)$resVendute[0]['totale'] : 0;

// Opere vendute nel periodo precedente
$resVendutePrec = $db->queryDB(
    "SELECT COUNT(*) as totale FROM ordine 
     WHERE data >= :dal AND data < :al",
    [':dal' => $dataPrecInizio, ':al' => $dataPrecFine]
);
$opereVendutePrec = $resVendutePrec ? (int)$resVendutePrec[0]['totale'] : 0;
    $stats = [
    'visite_totali'  => number_format($visiteTotali, 0, ',', '.'),
    'visite_perc'    => $calcPerc($visiteTotali, $visiteTotaliPrec),
    'registrazioni'  => number_format($totaleRegistrazioni, 0, ',', '.'),
    'reg_perc'       => $calcPerc($totaleRegistrazioni, $totaleRegistrazioniPrec),
    'vis_pagina'     => number_format($visPagina, 0, ',', '.'),
    'vis_pag_perc'   => $calcPerc($visPagina, $visPaginaPrec),
    'opere_vendute' => number_format($opereVendute, 0, ',', '.'),
'vendute_perc'  => $calcPerc($opereVendute, $opereVendutePrec),
    'movimenti'      => number_format($totaleMovimenti, 0, ',', '.'),
    'mov_perc'       => $calcPerc($totaleMovimenti, $totaleMovimentiPrec),
    'guadagni'       => $guadagni,
    'guad_perc'      => $calcPerc((int)$guadagni, (int)$guadagniPrec),
    'azioni_reg'     => $totaleRegistrazioni,
    'azioni_opere'   => $totaleOpere,
    'azioni_commenti'=> $totaleCommenti,
];

    // Dati grafici
    $labelGrafici = [];
    $datiVisite   = [];
    $datiPagine   = [];
    $datiGuadagni = [];

    $step = match(true) {
        $giorni <= 7  => 1,
        $giorni <= 30 => 7,
        $giorni <= 90 => 14,
        default       => 30,
    };

    for ($i = $giorni; $i >= 0; $i -= $step) {
    $dal = date('Y-m-d', strtotime("-{$i} days"));
    
    // L'ultimo punto è sempre oggi
    if ($i === 0) {
        $al = date('Y-m-d', strtotime('+1 day')); // domani per includere tutto oggi
    } else {
        $nextI = max(0, $i - $step);
        $al = date('Y-m-d', strtotime("-{$nextI} days"));
    }

    $labelGrafici[] = date('d/m', strtotime("-{$i} days"));

    $resV = $db->queryDB(
        "SELECT COUNT(*) as pageviews, COUNT(DISTINCT sessione) as visite
         FROM visita 
         WHERE data >= :dal AND data < :al",
        [':dal' => $dal . ' 00:00:00', ':al' => $al . ' 00:00:00']
    );
    $datiPagine[] = $resV ? (int)$resV[0]['pageviews'] : 0;
    $datiVisite[] = $resV ? (int)$resV[0]['visite']    : 0;

    $resG = $db->queryDB(
        "SELECT COALESCE(SUM(o.prezzo * 0.10), 0) as tot
         FROM ordine ord
         INNER JOIN opera o ON o.id = ord.idOpera
         WHERE ord.data >= :dal AND ord.data < :al",
        [':dal' => $dal . ' 00:00:00', ':al' => $al . ' 00:00:00']
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

        // Notifica l'artista dell'avvenuta approvazione
        UEmail::inviaEmail(
            $artista->getEmail(),
            "Il tuo profilo artista è stato approvato",
            UEmail::corpoArtistaApprovato($artista->getNome())
    );
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
        'data_registrazione' => $artista->getDataRegistrazione()->format('Y-m-d'),
        'biografia'          => $artista->getBiografia(),
        'stile_artistico'    => $artista->getStileArtistico(),
        'localita'           => $artista->getIndirizzo(),
        'data_documento'     => date('Y-m-d'), // mock
        'note_admin'         => '',
        'carta_identita' => $artista->getCartaIdentita(),
        'url_documento'  => '/Gallerist/uploads/documenti/' . $artista->getCartaIdentita(),
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
    // Dopo aver caricato $seg
$testoIncriminato = '';
$titoloOpera = '';
$urlAnteprimaOpera = '/Gallerist/img/default_opera.png';

$categoriaOpera = '';
$idOpera = 0;

if ($seg->getTipoTarget() === 'Commento') {
    $commento = FPersistentManager::load('ECommento', 'id', $seg->getIdTarget());
    if ($commento instanceof ECommento) {
        
        $testoIncriminato = $commento->getTesto();
        $opera = FPersistentManager::load('EOpera', 'id', $commento->getOpera()->getId());
        
        if ($opera instanceof EOpera) {
            $titoloOpera = $opera->getTitolo();
        }
        $idAutoreCommento = $commento->getAutore()->getId();
    }
}
// Dopo aver caricato $seg


if ($seg->getTipoTarget() === 'Opera') {
    $opera = FPersistentManager::load('EOpera', 'id', $seg->getIdTarget());
    if ($opera instanceof EOpera) {
        $idOpera = $opera->getId();
        $titoloOpera = $opera->getTitolo();
        $categoriaOpera = $opera->getCategoria()->getNome();
        
        // Carica immagine reale
        $immagini = FPersistentManager::load('EImmagine', 'idOpera', $opera->getId());
        if ($immagini !== null) {
            if (!is_array($immagini)) $immagini = [$immagini];
            if (!empty($immagini)) {
                $urlAnteprimaOpera = '/Gallerist/uploads/opere/' . $immagini[0]->getUrlFile();
            }
        }
    }
}
    if ($seg->getTipoTarget() === 'Commento' && isset($idAutoreCommento)) {
    $utenteSegnalato = FPersistentManager::load('EUtente', 'id', $idAutoreCommento);
} else {
    $utenteSegnalato = FPersistentManager::load('EUtente', 'id', $seg->getIdTarget());
}
    $utenteSegnalante = FPersistentManager::load('EUtente', 'id', $seg->getIdSegnalatore());

    // Storico segnalazioni reale
    $db = FDataBase::getInstance();
    $storicoResult = $db->queryDB(
        "SELECT s.dataSegnalazione as data, s.tipoOggetto as tipo,
                s.motivo, s.stato as stato_azione
         FROM segnalazione s
         WHERE s.idOggettoSegnalato = :id
         ORDER BY s.dataSegnalazione DESC",
        [':id' => $seg->getIdTarget()]
    );

    $storico = [];
    foreach ($storicoResult ?? [] as $row) {
        $storico[] = [
            'data'         => $row['data'],
            'tipo'         => $row['tipo'],
            'motivo'       => $row['motivo'],
            'stato_azione' => $row['stato_azione'],
        ];
    }

   $segnalazione = [
    'id'                  => $seg->getId(),
    'tipo_oggetto'        => $seg->getTipoTarget(),
    'autore_segnalazione' => $utenteSegnalante ? $utenteSegnalante->getNickname() : $seg->getIdSegnalatore(),
    'data_invio'          => $seg->getDataSegnalazione()->format('Y-m-d H:i:s'),
    'stato'               => $seg->getStato()->getNomeStato(),
    'motivo_principale'   => $seg->getMotivo(),
    'dettagli_aggiuntivi' => $seg->getNotaOpzionale(),
    'titolo_opera'        => $titoloOpera,
    'testo_incriminato'   => $testoIncriminato,
    'url_anteprima_opera' => $urlAnteprimaOpera,
    'id_opera'            => $idOpera,
    'categoria_opera'     => $categoriaOpera,
];

    $autoreContenuto = [
        'id'                    => $utenteSegnalato ? $utenteSegnalato->getId() : 0,
        'nickname'              => $utenteSegnalato ? $utenteSegnalato->getNickname() : 'N/D',
        'data_registrazione' => $utenteSegnalato ? $utenteSegnalato->getDataRegistrazione()->format('Y-m-d') : '',
        'stato'                 => $utenteSegnalato ? $utenteSegnalato->getStatoAccount() : '',
        'segnalazioni_ricevute' => count($storico), // ← reale
        'commenti_pubblicati'   => 0,               // mock
    ];

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('segnalazione',                $segnalazione);
    $vAdmin->smarty->assign('autore_contenuto',            $autoreContenuto);
    $vAdmin->smarty->assign('storico_segnalazioni_utente', $storico);
    
    $vAdmin->smarty->display('AdminSegnalazioni.tpl');
}

/**
 * Mostra la lista di tutti gli utenti bannati/provvedimenti.
 * Risponde all'URL: /Gallerist/Admin/bannati
 */
public function bannati() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $provvedimenti = FPersistentManager::getProvvedimentiAttivi();

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('provvedimenti', $provvedimenti);
    $vAdmin->smarty->display('AdminBannati.tpl');
}

/**
 * Mostra e gestisce le categorie.
 * Risponde all'URL: /Gallerist/Admin/gestisciCategorie
 */
public function gestisciCategorie() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    // Gestione POST per aggiunta categoria
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome        = trim($_POST['nome']        ?? '');
        $descrizione = trim($_POST['descrizione'] ?? '');

        if (!empty($nome)) {
            $categoria = new ECategoria($nome);
            FPersistentManager::store($categoria);
        }
        header('Location: /Gallerist/Admin/gestisciCategorie');
        exit;
    }

    $categorie = FPersistentManager::getCategorieTutte();

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('categorie', $categorie);
    $vAdmin->smarty->display('AdminCategorie.tpl');
}

/**
 * Mostra tutte le segnalazioni.
 * Risponde all'URL: /Gallerist/Admin/tutteSegnalazioni
 */
public function tutteSegnalazioni() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $segnalazioniList = FPersistentManager::getSegnalazioniTutte();

    $segnalazioniArray = [];
    foreach ($segnalazioniList as $seg) {
    // Carica il segnalante per ottenere il nickname
    $segnalante = FPersistentManager::load('EUtente', 'id', $seg->getIdSegnalatore());
    
    $segnalazioniArray[] = [
        'id'     => $seg->getId(),
        'tipo'   => $seg->getTipoTarget(),
        'motivo' => $seg->getMotivo(),
        'data'   => $seg->getDataSegnalazione()->format('Y-m-d'),
        'stato'  => $seg->getStato()->getNomeStato(),
        'autore' => $segnalante ? '@' . $segnalante->getNickname() : '#' . $seg->getIdSegnalatore(),
    ];
}

    $vAdmin = new VAdmin();
    $vAdmin->smarty->assign('segnalazioni', $segnalazioniArray);
    $vAdmin->smarty->display('AdminListaSegnalazioni.tpl');
}
public function eliminaCategoria() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $nome = trim($_POST['nome'] ?? '');
    if (!empty($nome)) {
        FPersistentManager::delete('ECategoria', 'nome', $nome);
    }

    header('Location: /Gallerist/Admin/gestisciCategorie');
    exit;
}
/**
 * Processa l'azione di moderazione su una segnalazione.
 * Risponde all'URL: /Gallerist/Admin/processaModerazione
 */
public function processaModerazione() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $idSegnalazione  = (int)($_POST['id_segnalazione']    ?? 0);
    $idUtente        = (int)($_POST['id_utente_segnalato'] ?? 0);
    $azione          = trim($_POST['azione_moderazione']   ?? 'nessuna');
    $tipoBan         = trim($_POST['tipo_ban']             ?? 'temporaneo');
    $durataBan       = (int)($_POST['durata_ban']          ?? 1);
    $nota            = trim($_POST['nota_moderazione']     ?? '');
    $rimuoviContenuto = isset($_POST['rimuovi_e_avvisa']);

    // 1. Applica il ban se richiesto
    if ($azione === 'ban' && $idUtente > 0) {
        $dataInizio = date('Y-m-d');
        if ($tipoBan === 'permanente') {
    $durataBan = 0;
}
        $dataFine   = $durataBan > 0 
            ? date('Y-m-d', strtotime("+{$durataBan} days")) 
            : null;

        $db = FDataBase::getInstance();
        $db->queryDB(
            "INSERT INTO provvedimento (tipoBan, dataInizio, dataFine, motivo, idUtenteSanzionato)
             VALUES (:tipo, :inizio, :fine, :motivo, :id)",
            [
                ':tipo'   => $tipoBan,
                ':inizio' => $dataInizio,
                ':fine'   => $dataFine,
                ':motivo' => $nota,
                ':id'     => $idUtente,
            ]
        );

        // Aggiorna stato account utente a Bannato
        FPersistentManager::update('EUtente', 'stato_account', EUtente::STATO_BANNATO, 'id', $idUtente);
    }
    if ($azione === 'ban' && $idUtente > 0) {
    // ... codice ban invariato
}

// ✅ AGGIUNGI QUI
// 1b. Rimuovi contenuto se richiesto
if ($rimuoviContenuto) {
    $db = FDataBase::getInstance();
    
    $segResult = $db->queryDB(
        "SELECT tipoOggetto, idOggettoSegnalato FROM segnalazione WHERE id = :id",
        [':id' => $idSegnalazione]
    );
    
    if (!empty($segResult)) {
        $tipo      = $segResult[0]['tipoOggetto'];
        $idOggetto = (int)$segResult[0]['idOggettoSegnalato'];
        
        if ($tipo === 'Commento') {
            $db->queryDB(
                "DELETE FROM commento WHERE id = :id",
                [':id' => $idOggetto]
            );
        }
        // Opera e Profilo: il ban nasconde già il contenuto automaticamente
    }
}

    // 2. Aggiorna stato segnalazione ad Archiviata
    if ($idSegnalazione > 0) {
        $db = FDataBase::getInstance();
        $db->queryDB(
            "UPDATE segnalazione SET stato = 'Archiviata' WHERE id = :id",
            [':id' => $idSegnalazione]
        );
    }

    header('Location: /Gallerist/Admin/dashboard?moderazione=completata');
    exit;
}
public function aggiungiCategoria() {
    if (!self::checkAdmin()) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $nome        = trim($_POST['nome']        ?? '');
    $descrizione = trim($_POST['descrizione'] ?? '');

    if (!empty($nome)) {
        $categoria = new ECategoria($nome, $descrizione);
        FPersistentManager::store($categoria);
    }

    header('Location: /Gallerist/Admin/dashboard');
    exit;
}
}