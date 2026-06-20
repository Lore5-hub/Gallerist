<?php

/**
 * Class VRegistrazione si occupa dell'input-output per il Caso d'Uso UC1: Registrazione Account.
 *
 * Responsabilità:
 *  - Mostrare il form di registrazione con scelta del ruolo (Utente / Artista)
 *  - Mostrare gli errori di validazione provenienti dal Control
 *  - Confermare all'utente l'esito della registrazione
 *
 * @package View
 */
class VRegistrazione
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
    //  UC1 — Step 1a/1b: L'utente chiede di registrarsi
    // =========================================================================

    /**
     * Mostra il form di registrazione vuoto con la scelta del ruolo.
     *
     * Il template riceve la variabile 'ruoloSelezionato' per mantenere il tab
     * attivo tra un reload e l'altro (utile in caso di errore sul form artista).
     *
     * @param string $ruoloSelezionato 'utente' (default) oppure 'artista'
     */
    public function mostraModuloRegistrazione(string $ruoloSelezionato = 'utente'): void
    {
        // L'utente non è ancora loggato: non assegniamo 'userlogged'
        $this->smarty->assign('ruoloSelezionato', $ruoloSelezionato);

        $this->smarty->display('registrazione.tpl');
    }

    // =========================================================================
    //  UC1 — Step 2a/2b: Registrazione Utente standard e relativi errori
    //  UC1 — Step 3a/3b: Registrazione Artista e relativi errori
    // =========================================================================

    /**
     * Mostra il form di registrazione con un messaggio di errore evidenziato.
     *
     * Chiamato dal Control ogni volta che la validazione dei dati fallisce,
     * sia per il flusso utente standard sia per quello artista.
     * Ricarica il form mantenendo il tab corretto e i dati già inseriti
     * (passati come array opzionale $datiPrecedenti per ripopolare i campi).
     *
     * Chiavi di errore gestite:
     *  - 'campo_obbligatorio'   → campo obbligatorio non compilato
     *  - 'email_non_valida'     → formato email non rispettato
     *  - 'email_duplicata'      → email già presente nel database
     *  - 'formato_telefono'     → numero di telefono non valido (es. manca prefisso)
     *  - 'password_corta'       → password inferiore al minimo di sicurezza
     *  - 'documento_mancante'   → carta d'identità non allegata (solo flusso artista)
     *  - 'formato_documento'    → formato file del documento non accettato
     *  - 'errore_generico'      → errore interno durante la persistenza
     *
     * @param string $codiceErrore  Chiave che identifica il tipo di errore
     * @param string $ruolo         'utente' o 'artista' — mantiene il tab attivo
     * @param array  $datiPrecedenti Dati già inseriti per ripopolare il form
     */
    public function mostraErrore(
        string $codiceErrore,
        string $ruolo = 'utente',
        array $datiPrecedenti = []
    ): void {
        // Manteniamo il tab corretto (utente / artista) dopo il reload
        $this->smarty->assign('ruoloSelezionato', $ruolo);

        // Ripopoliamo i campi con i dati già inseriti dall'utente
        // in modo che non debba riscriverli da capo dopo un errore
        if (!empty($datiPrecedenti)) {
            $this->smarty->assign('datiForm', $datiPrecedenti);
        }

        // Traduzione del codice di errore nel messaggio da mostrare a schermo
        switch ($codiceErrore) {
            case 'campo_obbligatorio':
                $this->smarty->assign('erroreRegistrazione', 'Tutti i campi obbligatori devono essere compilati.');
                break;

            case 'email_non_valida':
                $this->smarty->assign('erroreRegistrazione', 'Il formato dell\'indirizzo email non è valido.');
                break;

            case 'email_duplicata':
                $this->smarty->assign('erroreRegistrazione', 'Questa email è già associata a un account esistente.');
                break;

            case 'formato_telefono':
                $this->smarty->assign('erroreRegistrazione', 'Numero di telefono non valido. Usa il formato: +39 3471234567');
                break;

            case 'password_corta':
                $this->smarty->assign('erroreRegistrazione', 'La password deve contenere almeno 8 caratteri.');
                break;

            case 'documento_mancante':
                // Solo flusso artista: la carta d'identità è obbligatoria per la validazione
                $this->smarty->assign('erroreRegistrazione', 'È obbligatorio allegare la foto del documento di riconoscimento.');
                break;

            case 'formato_documento':
                $this->smarty->assign('erroreRegistrazione', 'Il documento deve essere in formato JPG, PNG o PDF.');
                break;

            case 'errore_generico':
            default:
                $this->smarty->assign('erroreRegistrazione', 'Si è verificato un errore durante la registrazione. Riprova più tardi.');
                break;
        }

        $this->smarty->display('registrazione.tpl');
    }

    // =========================================================================
    //  UC1 — Post-condizioni: feedback di esito registrazione
    // =========================================================================

    /**
     * Mostra un messaggio informativo all'utente al termine del processo.
     *
     * Usa CUtente::isLogged() come fonte di verità per lo stato della sessione,
     * anziché fidarsi del Control (pattern da VOpera::mostraDettaglioOpera).
     *
     * Tipi di messaggio gestiti:
     *  - 'registrazione_completata' → utente standard registrato e loggato automaticamente
     *  - 'artista_in_attesa'        → artista in attesa di validazione, NON loggato
     *
     * @param string $tipoMessaggio Chiave che identifica il tipo di esito
     */
    public function mostraMessaggio(string $tipoMessaggio): void
    {
        // Fonte di verità centralizzata per lo stato del login:
        // non ci fidiamo di ciò che il Control ci dice di aver fatto,
        // ma interroghiamo direttamente la sessione (pattern da VOpera)
        if (CUtente::isLogged()) {
            $this->smarty->assign('userlogged', 'loggato');
        }

        switch ($tipoMessaggio) {
            case 'registrazione_completata':
                $this->smarty->assign(
                    'messaggioSuccesso',
                    'Registrazione completata con successo! Benvenuto su Gallerist.'
                );
                break;

            case 'artista_in_attesa':
                // L'artista NON viene loggato: deve attendere la validazione dell'admin.
                // Il template mostrerà messaggioInfo (non messaggioSuccesso) per
                // comunicare che l'azione è in sospeso, non ancora conclusa.
                $this->smarty->assign(
                    'messaggioInfo',
                    'Il tuo profilo artista è stato creato ed è in attesa di verifica '
                    . 'da parte dell\'amministratore. '
                    . 'Riceverai una email non appena il tuo account sarà attivato.'
                );
                break;

            default:
                $this->smarty->assign('messaggioInfo', 'Operazione completata.');
                break;
        }

        $this->smarty->display('registrazione_esito.tpl');
    }
    
    /**
     * Codifica un'immagine in Base64 per l'embed diretto nell'HTML.
     *
     * Usato per l'anteprima dell'immagine profilo o per visualizzare la carta
     * d'identità nel pannello admin dopo la registrazione artista.
     * Segue lo stesso pattern di VOpera::codificaImmagine().
     *
     * @param mixed       $immagine    Oggetto EImmagine (con getData() e getType()),
     *                                 oppure null se non presente
     * @param string      $tipoDefault Tipo MIME di fallback (es. 'profilo', 'documento')
     * @return array                   [string $mimeType, string $base64Data]
     */
    private function codificaImmagine($immagine, string $tipoDefault): array
    {
        if (isset($immagine) && $immagine !== null) {
            $base64 = base64_encode($immagine->getData());
            $mime   = $immagine->getType();
        } else {
            // Immagine di default in base al tipo richiesto
            $nomeDefault = ($tipoDefault === 'documento')
                ? 'default_documento.png'
                : 'default_avatar.png';

            $percorso = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/Smarty/immagini/' . $nomeDefault;
            $base64   = base64_encode(file_get_contents($percorso));
            $mime     = 'image/png';
        }

        return [$mime, $base64];
    }
}
?>