<?php
// Control/CCatalogo.php

/**
 * Classe di controllo per il Caso d'Uso: Esplorazione e Visualizzazione Catalogo (UC2).
 *
 * NOTA ARCHITETTURALE — uso di FPersistentManager vs Foundation dirette:
 * Le operazioni CRUD standard (load per PK, store, update, delete) transitano
 * sempre attraverso FPersistentManager, che funge da Facade e disaccoppia il
 * Controller dalle singole classi Foundation.
 * I metodi di dominio specifici (FOpera::loadRecenti, FOpera::ricercaFiltrata,
 * FCategoria::loadAll) vengono invece chiamati direttamente sulla Foundation
 * perché non hanno un corrispondente generico nel Manager: aggiungere un caso
 * speciale nel Manager per ogni query custom violerebbe il principio di
 * responsabilità singola del Facade stesso. Questa eccezione è documentata e
 * limitata ai soli metodi che il Manager non può astrarre in modo generico.
 *
 * @package Control
 */
class CCatalogo {

    /**
     * Operazione di sistema (Step 1): L'utente richiede l'esplorazione del catalogo.
     * Recupera le categorie per i filtri e la griglia iniziale delle opere recenti.
     */
   public function esploraCatalogo(): void {
    $categorie = FCategoria::loadAll() ?? [];
    $opere     = FOpera::loadRecenti() ?? [];
    
    $view = new VCatalogo();
    $view->mostraPaginaCatalogo($categorie, $opere);
}

    /**
     * Operazione di sistema (Step 2): L'utente applica filtri o criteri di ricerca.
     *
     * @param string $parolaChiave Testo di ricerca libera su titolo e descrizione
     * @param string $categoria    Nome della categoria selezionata (stringa vuota = nessun filtro)
     * @param string $ordinamento  'recenti' | 'prezzo_asc' | 'prezzo_desc'
     */
    public function filtraCatalogo(
    string $parolaChiave = '',
    string $categoria    = '',
    string $ordinamento  = 'recenti'
): void {
    
    // 🟢 LA MODIFICA: Se i dati arrivano dalla barra URL (?categoria=... o ?parola_chiave=...)
    // li prendiamo da $_GET, altrimenti teniamo il valore di default passato dal Front Controller.
    $parolaChiave = isset($_GET['parola_chiave']) ? $_GET['parola_chiave'] : $parolaChiave;
    $categoria    = isset($_GET['categoria'])    ? $_GET['categoria']    : $categoria;
    $ordinamento  = isset($_GET['ordinamento'])  ? $_GET['ordinamento']  : $ordinamento;

    // ... Tutto il resto del tuo codice rimane identico ed è perfetto!
    $ordinamentiValidi = ['recenti', 'prezzo_asc', 'prezzo_desc'];
    $parametriPuliti   = [
        'parola_chiave' => trim($parolaChiave),
        'categoria'     => trim($categoria),
        'ordinamento'   => in_array(trim($ordinamento), $ordinamentiValidi, true) ? trim($ordinamento) : 'recenti',
        'prezzo_max'    => isset($_GET['prezzo_max']) && $_GET['prezzo_max'] > 0 ? (float)$_GET['prezzo_max'] : null,
    ];

    $opereFiltrate = FOpera::ricercaFiltrata($parametriPuliti) ?? [];
    $categorie     = FCategoria::loadAll() ?? [];

    $view = new VCatalogo();
    $view->mostraRisultatiFiltrati($opereFiltrate, $categorie, $parametriPuliti);
}

    /**
     * Operazione di sistema (Step 3): L'utente clicca su un'opera per vederne la scheda di dettaglio.
     *
     * @param int $idOpera Identificativo dell'opera da caricare
     */
    public function visualizzaDettagliOpera(int $idOpera): void {
        $view      = new VCatalogo();
        $categorie = FCategoria::loadAll() ?? []; // necessarie anche in caso di errore (navbar)

        // Operazione CRUD standard: transita dal Manager
        $opera = FPersistentManager::load('EOpera', 'id', $idOpera);

        if ($opera === null) {
            $view->mostraErrore('opera_non_trovata', $categorie);
            return;
        }

        // Aggregazione commenti: loadByField su campo non-PK, delegabile al Manager
        $commenti = FPersistentManager::load('ECommento', 'idOpera', $idOpera);
if ($commenti !== null) {
    if (!is_array($commenti)) {
        $commenti = [$commenti]; // ← wrap singolo oggetto in array
    }
    foreach ($commenti as $commento) {
        $opera->addCommento($commento);
    }
}

        // Aggregazione immagini: loadByField('idOpera') restituisce array ordinato per inserimento;
        // la prima immagine è la copertina (convenzione del progetto, cfr. EImmagine e VCatalogo)
        $immagini = FPersistentManager::load('EImmagine', 'idOpera', $idOpera);
        if (is_array($immagini)) {
            foreach ($immagini as $immagine) {
                $opera->addImmagine($immagine);
            }
        } elseif ($immagini instanceof EImmagine) {
            $opera->addImmagine($immagini);
        }

        // Aggregazione tag: FTag::loadByField intercetta 'idOpera' e usa la JOIN su opera_tag
        $tags = FPersistentManager::load('ETag', 'idOpera', $idOpera);
        if (is_array($tags)) {
            foreach ($tags as $tag) {
                $opera->addTag($tag);
            }
        } elseif ($tags instanceof ETag) {
            $opera->addTag($tags);
        }

        // Metodo custom di dominio: non astraibile dal Manager (vedi nota architetturale)
        $altreOpere = FOpera::loadByArtista($opera->getArtista()->getId(), $idOpera) ?? [];
$valuta = $_GET['valuta'] ?? 'EUR';

$prezzoConvertito = null;

if ($valuta !== 'EUR') {
    
    $prezzoConvertito = UValutaService::converti($opera->getPrezzo(), $valuta);
}

$view->mostraSchedaDettaglio($opera, $altreOpere, false, $prezzoConvertito, $valuta);
    }
    public function homepage(): void {
    $ultimeOpere = FOpera::loadPiuApprezzate(6);
    $view = new VCatalogo();
    $view->mostraHomepage($ultimeOpere ?? []);
}
 public function visualizzaProfiloArtista(int $idArtista): void {
    $sessione = USession::getInstance();
    if ($sessione->esisteValore('utente_loggato')) {
        $utente = $sessione->getValore('utente_loggato');
        if ($utente->getId() === $idArtista) {
            header('Location: /Gallerist/utente/profilo');
            exit;
        }
    }

    $artista = FPersistentManager::load('EArtista', 'id', $idArtista);

    if (!$artista instanceof EArtista) {
        // È un utente normale
        $utente = FPersistentManager::load('EUtente', 'id', $idArtista);
        if (!$utente instanceof EUtente) {
            $view = new VCatalogo();
            $view->mostraErrore('utente_non_trovato');
            return;
        }

        // Carica recensioni scritte dall'utente
        $recensioniScritte = [];
        $commenti = FPersistentManager::load('ECommento', 'idAutore', $idArtista);
        if ($commenti !== null) {
            if (!is_array($commenti)) $commenti = [$commenti];
            $recensioniScritte = $commenti;
        }

        // Conta acquisti
        $numeroAcquisti = FPersistentManager::contaAcquistiUtente($idArtista);

        $view = new VCatalogo();
        $view->mostraProfiloPubblico($utente, [], $recensioniScritte, $numeroAcquisti);
        return;
    }

    // È un artista
    $opere = FOpera::loadByArtista($idArtista, -1) ?? [];

    $view = new VCatalogo();
    $view->mostraProfiloPubblico($artista, $opere);
}
}
?>