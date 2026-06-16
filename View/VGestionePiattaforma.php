<?php

/**
 * Class VGestionePiattaforma si occupa dell'input-output per le funzionalità dell'Amministratore (UC1, UC2)
 * Gestione segnalazioni e applicazione provvedimenti.
 * @package View
 */
class VGestionePiattaforma
{
    /** @var Smarty */
    private $smarty;

    /**
     * Funzione che inizializza e configura smarty.
     */
    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * UC1: Mostra la Dashboard con tutte le Segnalazioni
     * Mostra la tabella riassuntiva delle segnalazioni presenti sulla piattaforma.
     * @param array $segnalazioni Elenco di oggetti ESegnalazione
     * @param string|null $conferma Messaggio opzionale di successo (es. "archiviato", "bannato")
     */
    public function mostraDashboardSegnalazioni($segnalazioni, $conferma = null) {
        // L'utente che accede qui è sicuramente l'admin loggato
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('ruolo', "Amministratore");

        // Passiamo l'array di oggetti ESegnalazione al template
        $this->smarty->assign('segnalazioni', $segnalazioni);

        // Gestione dei feedback visivi di successo
        if ($conferma != null) {
            switch ($conferma) {
                case "archiviato":
                    $this->smarty->assign('messaggioSuccesso', "Segnalazione archiviata con successo.");
                    break;
                case "provvedimento_applicato":
                    $this->smarty->assign('messaggioSuccesso', "Provvedimento applicato e segnalazione chiusa.");
                    break;
            }
        }

        $this->smarty->display('dashboard_segnalazioni.tpl');
    }

    /**
     * UC1: Dettaglio della Segnalazione
     * Mostra le informazioni specifiche di una segnalazione e l'oggetto incriminato (es. un commento).
     * @param ESegnalazione $segnalazione L'oggetto segnalazione specifico
     * @param mixed $oggettoSegnalato L'oggetto Entity reale che è stato segnalato (es. istanza di ECommento)
     */
    public function mostraDettaglioSegnalazione($segnalazione, $oggettoSegnalato) {
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('ruolo', "Amministratore");

        // Assegniamo i dati della segnalazione
        $this->smarty->assign('segnalazione', $segnalazione);
        
        // Passiamo l'oggetto relazionato (può essere un commento o un profilo utente)
        $this->smarty->assign('oggettoSegnalato', $oggettoSegnalato);
        
        // Specifichiamo il tipo di oggetto per permettere al template .tpl di fare controlli grafici condizionali
        $this->smarty->assign('tipoOggetto', $segnalazione->getTipoOggetto());

        $this->smarty->display('dettaglio_segnalazione.tpl');
    }

    /**
     * UC2: Form Applicazione Provvedimento (Ban)
     * Mostra il modulo per sanzionare l'autore del contenuto offensivo.
     * @param EUtente $utente Sospettato / Utente da sanzionare
     * @param string|null $errore Eventuale stringa di errore (es. "motivo_mancante", "data_invalida")
     */
    public function mostraFormProvvedimento($utente, $errore = null) {
        $this->smarty->assign('userlogged', "loggato");
        $this->smarty->assign('ruolo', "Amministratore");

        // Passiamo i dati dell'utente che sta per subire la sanzione
        $this->smarty->assign('utenteSanzionato', $utente);

        // Gestione degli errori di compilazione del form
        if ($errore != null) {
            switch ($errore) {
                case "motivo_mancante":
                    $this->smarty->assign('erroreMotivo', "È obbligatorio inserire una motivazione.");
                    break;
                case "durata_non_valida":
                    $this->smarty->assign('erroreDurata', "La data di fine provvedimento non è valida.");
                    break;
            }
        }

        $this->smarty->display('form_provvedimento.tpl');
    }
}