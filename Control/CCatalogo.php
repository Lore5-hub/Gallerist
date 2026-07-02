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
        // Metodi custom di dominio: non astraibili dal Manager (vedi nota architetturale)
        $categorie = FCategoria::loadAll() ?? [];
        $opere     = FOpera::loadRecenti() ?? [];
       $isLogged = isset($_SESSION['id_utente']) ? true : false;
        $view = new VCatalogo();

        $view->mostraPaginaCatalogo($categorie, $opere, $isLogged);
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
        if (is_array($commenti)) {
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
    require_once 'Control/CValutaService.php';
    $prezzoConvertito = CValutaService::converti($opera->getPrezzo(), $valuta);
}

$view->mostraSchedaDettaglio($opera, $altreOpere, false, $prezzoConvertito, $valuta);
    }
    public function homepage() 
    {
        // PASSO 1: Recupera i dati che servono dal Database (Model/Foundation)
        // Ad esempio, potresti voler mostrare le ultime 6 opere d'arte caricate nella galleria
        // (Ipotizzo il nome di una classe Entity o Foundation, usa le tue)
        $ultimeOpere = FOpera::loadRecenti(6); 

        // PASSO 2: Prendi l'istanza di Smarty per gestire la View
        // Nota: se avete creato una classe apposita per la View (es. VCatalogo), 
        // userai i metodi di quella classe. Altrimenti istanzi Smarty direttamente:
        $smarty = StartSmarty::configuration(); // o la vostra utility per richiamare Smarty

        // PASSO 3: Passa i dati a Smarty e mostra la pagina
        // Assegniamo l'array delle opere a una variabile Smarty che useremo nel template
       $smarty->assign('opere_popolari', $ultimeOpere ?? []);
        $smarty->assign('titolo', 'Benvenuti nella Galleria d\'Arte Gallerist');

        // Diciamo a Smarty di renderizzare il file del template della homepage
        $smarty->display('homepage.tpl');
    }
 public function visualizzaProfiloArtista(int $idArtista): void {
    $artista = FPersistentManager::load('EArtista', 'id', $idArtista);

    if (!$artista instanceof EArtista) {
        $view = new VCatalogo();
        $view->mostraErrore('utente_non_trovato');
        return;
    }

    $opere = FOpera::loadByArtista($idArtista, -1) ?? [];

    $view = new VCatalogo();
    $view->mostraProfiloPubblico($artista, $opere);
}
}
?>