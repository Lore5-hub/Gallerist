<?php

/**
 * Class VCatalogo si occupa dell'input-output per il Caso d'Uso UC2:
 * Esplorazione e Visualizzazione Catalogo.
 *
 * Responsabilità:
 *  - Mostrare la pagina di esplorazione con barra di ricerca, filtri e griglia opere
 *  - Aggiornare la griglia dopo l'applicazione di filtri / ricerca testuale
 *  - Mostrare la scheda di dettaglio di una singola opera con commenti e opere correlate
 *  - Gestire e comunicare gli errori (opera non trovata, catalogo vuoto)
 *
 * Accessibile da utenti non loggati e loggati (UC2 non richiede autenticazione).
 *
 * @package View
 */
class VCatalogo
{
    /** @var Smarty */
    private $smarty;

    /**
     * Inizializza e configura Smarty tramite il factory centralizzato del progetto.
     */
    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    // =========================================================================
    //  UC2 — Step 1a/1b: L'utente richiede l'esplorazione del catalogo
    // =========================================================================

    /**
     * Mostra la pagina iniziale del catalogo con la griglia delle opere recenti.
     *
     * Corrisponde al passo 1b dell'UC2: il sistema mostra la pagina di esplorazione
     * con barra di ricerca, filtri per categoria, criteri di ordinamento e griglia
     * iniziale di opere popolari/recenti.
     *
     * Accessibile anche da utenti non loggati: lo stato di sessione viene verificato
     * tramite CUtente::isLogged() (fonte di verità centralizzata).
     *
     * @param array $categorie  Array di oggetti ECategoria per popolare il menu filtri
     * @param array $opere      Array di oggetti EOpera per la griglia iniziale
     */
    public function mostraPaginaCatalogo(array $categorie, array $opere,bool $isLogged = false): void
    {
        // Stato sessione: verificato centralmente, non assumiamo nulla dal Control
        if ($isLogged) {
            $this->smarty->assign('userlogged', 'loggato');
        }

        // Categorie per la sidebar/dropdown dei filtri
        $this->smarty->assign('categorie', $categorie);

        // Griglia opere con copertine codificate in Base64
        $this->smarty->assign('opere', $opere);
        $this->smarty->assign('copertineOpere', $this->codificaCopertine($opere));

        // Flag che indica al template che siamo nella visualizzazione iniziale
        // (nessun filtro attivo, nessuna parola chiave inserita)
        $this->smarty->assign('filtriAttivi', false);

        $this->smarty->display('catalogo.tpl');
    }

    // =========================================================================
    //  UC2 — Step 2a/2b: L'utente applica filtri, parola chiave, ordinamento
    // =========================================================================

    /**
     * Mostra la griglia delle opere filtrate/ordinate dopo una ricerca.
     *
     * Corrisponde al passo 2b dell'UC2: il sistema elabora la richiesta, filtra
     * il database e visualizza le opere corrispondenti ordinate secondo il criterio
     * specificato dall'utente.
     *
     * Mantiene i filtri applicati nei campi del form (UX: l'utente vede cosa ha cercato).
     * Gestisce il caso di lista vuota mostrando un messaggio dedicato anziché
     * una griglia vuota silenziosa.
     *
     * @param array  $opere           Array di oggetti EOpera risultanti dalla ricerca
     * @param array  $categorie       Array di oggetti ECategoria (per mantenere i filtri visibili)
     * @param array  $parametriUsati  I parametri puliti usati dal Control (parola_chiave,
     *                                categoria, ordinamento) — per ripopolare il form
     */
    public function mostraRisultatiFiltrati(
        array $opere,
        array $categorie,
        array $parametriUsati = [],
        bool $isLogged= false
    ): void {
        if ($isLogged) {
            $this->smarty->assign('userlogged', 'loggato');
        }

        // Categorie sempre presenti per permettere all'utente di cambiare filtro
        $this->smarty->assign('categorie', $categorie);

        // Risultati della ricerca con copertine
        $this->smarty->assign('opere', $opere);
        $this->smarty->assign('copertineOpere', $this->codificaCopertine($opere));

        // Flag che attiva nel template il pannello "risultati per: ..."
        $this->smarty->assign('filtriAttivi', true);

        // Ripopolamento dei campi di ricerca con i valori usati
        // (UX: l'utente vede esattamente cosa ha cercato/filtrato)
        if (!empty($parametriUsati)) {
            $this->smarty->assign('filtroParolaChiave', $parametriUsati['parola_chiave'] ?? '');
            $this->smarty->assign('filtroCategoria',    $parametriUsati['categoria']     ?? '');
            $this->smarty->assign('filtroOrdinamento',  $parametriUsati['ordinamento']   ?? 'recenti');
        }

        // Messaggio se la ricerca non ha prodotto risultati
        if (empty($opere)) {
            $this->smarty->assign(
                'messaggioVuoto',
                'Nessuna opera corrisponde ai criteri di ricerca. Prova a modificare i filtri.'
            );
        }

        $this->smarty->display('Catalogo.tpl');
    }

    // =========================================================================
    //  UC2 — Step 3a/3b: L'utente clicca su un'opera per vederne il dettaglio
    // =========================================================================

    /**
     * Mostra la scheda di dettaglio completa di un'opera.
     *
     * Corrisponde al passo 3b dell'UC2: il sistema apre la pagina dell'opera mostrando
     * immagine, titolo, profilo dell'artista, commenti/valutazioni e altre opere
     * dello stesso artista.
     *
     * Le immagini dell'opera vengono tutte codificate in Base64.
     * La valutazione media viene calcolata direttamente sull'oggetto EOpera
     * (tramite EOpera::getValutazioneMedia()), senza logica aggiuntiva nella View.
     *
     * Il form di inserimento recensione viene mostrato solo agli utenti loggati
     * (il template condizionerà la sezione su {if $userlogged == 'loggato'}).
     *
     * @param EOpera $opera       L'opera di cui mostrare il dettaglio (con commenti
     *                            e immagini già aggregati dal Control via addCommento/addImmagine)
     * @param array  $altreOpere  Altre opere dello stesso artista (esclusa quella corrente),
     *                            mostrate nella sezione "Scopri altri lavori"
     */
    public function mostraSchedaDettaglio(EOpera $opera, array $altreOpere, bool $isLogged=false, ?EPrezzo $prezzoConvertito = null, string $valutaSelezionata = 'EUR'): void
    {
        if ($isLogged) {
            $this->smarty->assign('userlogged', 'loggato');
        }

        // Dati principali dell'opera
        $this->smarty->assign('opera',   $opera);
        $this->smarty->assign('artista', $opera->getArtista());

        // Immagini dell'opera (tutte, non solo la copertina) codificate in Base64
        // La prima immagine dell'array è la copertina (convenzione del progetto)
        $immaginiCodificate = [];
        foreach ($opera->getImmagini() as $img) {
            list($mime, $b64) = $this->codificaImmagine($img, 'opera');
            $immaginiCodificate[] = ['type' => $mime, 'pic64' => $b64];
        }
        // Se l'opera non ha immagini, forniamo almeno il placeholder per la copertina
        if (empty($immaginiCodificate)) {
            list($mime, $b64) = $this->codificaImmagine(null, 'opera');
            $immaginiCodificate[] = ['type' => $mime, 'pic64' => $b64];
        }
        $this->smarty->assign('immaginiOpera', $immaginiCodificate);

        // Valutazione media calcolata da EOpera::getValutazioneMedia()
        // La View non fa calcoli: chiede all'Entity il valore già pronto
        $this->smarty->assign('valutazioneMedia', $opera->getValutazioneMedia());

        // Commenti già aggregati dentro $opera dal Control (via addCommento)
        $this->smarty->assign('commenti', $opera->getCommenti());

        // Sezione "Altre opere dell'artista" con relative copertine
        $this->smarty->assign('altreOpere',         $altreOpere);
        $this->smarty->assign('copertineAltreOpere', $this->codificaCopertine($altreOpere));
if ($prezzoConvertito !== null) {
        $this->smarty->assign('prezzoConvertito', $prezzoConvertito);
    }
    $this->smarty->assign('valutaSelezionata', $valutaSelezionata);
        $this->smarty->display('DettaglioOpera.tpl');
    }

    // =========================================================================
    //  Gestione errori
    // =========================================================================

    /**
     * Mostra un messaggio di errore contestuale nella pagina del catalogo.
     *
     * Chiavi gestite:
     *  - 'opera_non_trovata'  → l'ID passato non corrisponde ad alcuna opera nel DB
     *  - 'catalogo_vuoto'     → il database non contiene ancora opere pubblicate
     *  - 'errore_generico'    → errore interno non classificato
     *
     * @param string $codiceErrore  Chiave semantica dell'errore
     * @param array  $categorie     Categorie da passare al template (per mantenere i filtri)
     */
    public function mostraErrore(string $codiceErrore, array $categorie = []): void
    {
        if (USession::getInstance()->esisteValore('utente_loggato')) {
            $this->smarty->assign('userlogged', 'loggato');
        }

        // Categorie: anche in caso di errore il menu di navigazione rimane funzionante
        if (!empty($categorie)) {
            $this->smarty->assign('categorie', $categorie);
        }

        switch ($codiceErrore) {
            case 'opera_non_trovata':
                $this->smarty->assign(
                    'errore',
                    'L\'opera richiesta non è stata trovata o non è più disponibile.'
                );
                break;

            case 'catalogo_vuoto':
                $this->smarty->assign(
                    'errore',
                    'Il catalogo non contiene ancora opere pubblicate. Torna a trovarci presto!'
                );
                break;

            case 'errore_generico':
            default:
                $this->smarty->assign(
                    'errore',
                    'Si è verificato un errore nel caricamento del catalogo. Riprova più tardi.'
                );
                break;
        }

        $this->smarty->display('catalogo.tpl');
    }

    // =========================================================================
    //  Helper privati
    // =========================================================================

    /**
     * Codifica in Base64 la copertina di ogni opera di un array.
     *
     * Usato da mostraPaginaCatalogo() e mostraRisultatiFiltrati() per preparare
     * le immagini della griglia, e da mostraSchedaDettaglio() per le card
     * delle opere correlate.
     *
     * Restituisce un array indicizzato per ID opera:
     *   [ $idOpera => ['type' => 'image/jpeg', 'pic64' => '...'] ]
     *
     * @param array $opere Array di oggetti EOpera
     * @return array
     */
    private function codificaCopertine(array $opere): array
    {
        $copertine = [];
        foreach ($opere as $opera) {
            // La copertina è la prima immagine dell'array (convenzione del progetto)
            $immagini = $opera->getImmagini();
            $copertina = !empty($immagini) ? $immagini[0] : null;

            list($mime, $b64) = $this->codificaImmagine($copertina, 'opera');
            $copertine[$opera->getId()] = ['type' => $mime, 'pic64' => $b64];
        }
        return $copertine;
    }

    /**
     * Codifica una singola immagine in Base64, con fallback all'immagine di default.
     *
     * Segue lo stesso pattern di VOpera::codificaImmagine() e VRegistrazione::codificaImmagine()
     * per coerenza con il resto del progetto.
     *
     * @param mixed  $immagine    Oggetto EImmagine (con getData() e getType()), oppure null
     * @param string $tipoDefault Contesto di default: 'opera' | 'avatar'
     * @return array              [string $mimeType, string $base64Data]
     */
    private function codificaImmagine($immagine, string $tipoDefault): array
{
    $b64  = '';
    $mime = 'image/png';

    if (isset($immagine) && $immagine !== null) {
        $dati = $immagine->getData();
        if ($dati !== null) {
            $b64  = base64_encode($dati);
            $mime = $immagine->getType();
        } else {
            $percorso  = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/img/default_opera.png';
            $contenuto = file_get_contents($percorso);
            $b64       = base64_encode($contenuto !== false ? $contenuto : '');
        }
    } else {
        $nomeDefault = ($tipoDefault === 'avatar')
            ? 'default_avatar.png'
            : 'default_opera.png';

        $percorso  = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/img/' . $nomeDefault;
        $contenuto = file_get_contents($percorso);
        $b64       = base64_encode($contenuto !== false ? $contenuto : '');
    }

    return [$mime, $b64];
}
    /**
 * Mostra il profilo pubblico di un artista.
 */
public function mostraProfiloPubblico(EUtente $utente, array $opere, array $recensioniScritte = [], int $numeroAcquisti = 0): void {
    $this->smarty->assign('utente',             $utente);
    $this->smarty->assign('opere',              $opere);
    $this->smarty->assign('recensioni_scritte', $recensioniScritte);
    $this->smarty->assign('numero_acquisti',    $numeroAcquisti);
    $this->smarty->display('ProfiloPubblico.tpl');
}
}
?>