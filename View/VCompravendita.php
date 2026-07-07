<?php

/**
 * Class VCompravendita si occupa dell'input-output per il Caso d'Uso UC3:
 * Compravendita Opera d'Arte.
 *
 * Responsabilità:
 *  - Mostrare il riepilogo dell'ordine con dati opera, acquirente e spedizione
 *  - Confermare visivamente l'acquisto diretto andato a buon fine
 *  - Mostrare il modulo per l'inserimento di una proposta d'offerta alternativa
 *  - Confermare l'invio della proposta d'offerta all'artista
 *  - Gestire e comunicare tutti gli errori del flusso (opera non disponibile,
 *    dati mancanti, cifra non valida, errori di persistenza)
 *
 * Accessibile solo da utenti loggati (precondizione dell'UC3).
 * Lo stato di sessione viene verificato centralmente tramite CUtente::isLogged().
 *
 * @package View
 */
class VCompravendita
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
    //  UC3 — Step 1a/1b: L'utente clicca "Acquista" — riepilogo ordine
    // =========================================================================

    /**
     * Mostra la schermata di riepilogo dell'ordine prima della conferma.
     *
     * Corrisponde al passo 1b dell'UC3: il sistema mostra il riepilogo dell'ordine
     * con totale articolo, indirizzo di spedizione precompilato dai dati del profilo
     * e costo di spedizione. L'utente può modificare l'indirizzo prima di confermare.
     *
     * I dati personali (nome, cognome, indirizzo) vengono estratti dall'oggetto EUtente
     * passato dal Control, che li ha già caricati dalla sessione + Foundation.
     *
     * @param EUtente $utente          L'acquirente loggato (per precompilare nome/indirizzo)
     * @param EOpera  $opera           L'opera che si sta per acquistare
     * @param EPrezzo $prezzoSpedizione Il costo di spedizione calcolato dal Control
     */
    public function mostraRiepilogoOrdine(
        EUtente $utente,
        EOpera  $opera,
        EPrezzo $prezzoSpedizione,
        ?EArtista $artista = null
    ): void {
        // UC3 richiede login: verifichiamo centralmente prima di mostrare dati sensibili
        if (USession::getInstance()->esisteValore('utente_loggato')) {
    $this->smarty->assign('userlogged', 'loggato');
}

        // Dati dell'acquirente per precompilare il form di spedizione
        $this->smarty->assign('acquirente', $utente);

        // Dati dell'opera da acquistare (titolo, artista, prezzo)
        $this->smarty->assign('opera',   $opera);
         $this->smarty->assign('artista',    $artista ?? $opera->getArtista());

        // Copertina dell'opera codificata in Base64 per il riepilogo visivo
        $immagini  = $opera->getImmagini();
        $copertina = !empty($immagini) ? $immagini[0] : null;
        list($mime, $b64) = $this->codificaImmagine($copertina, 'opera');
        $this->smarty->assign('copertina', ['type' => $mime, 'pic64' => $b64]);

        // Prezzi separati: il template li mostra in tre righe distinte
        // (totale articolo / spedizione / totale ordine) come da UC3 step 2a
        $this->smarty->assign('prezzoArticolo',   $opera->getPrezzo());
        $this->smarty->assign('prezzoSpedizione', $prezzoSpedizione);

        // Totale ordine calcolato qui nella View sommando i due EPrezzo
        // (il Control non ha ancora un EOrdine in questo step: lo crea solo alla conferma)
        $totale = new EPrezzo(
            $opera->getPrezzo()->getValore() + $prezzoSpedizione->getValore(),
            $opera->getPrezzo()->getValuta()
        );
        $this->smarty->assign('totaleOrdine', $totale);

        $this->smarty->display('RiepilogoOrdine.tpl');
    }

    // =========================================================================
    //  UC3 — Step 2a/2b: L'utente conferma il pagamento — acquisto diretto
    // =========================================================================

    /**
     * Mostra la pagina di conferma dopo un acquisto diretto completato con successo.
     *
     * Corrisponde al passo 2b dell'UC3: il sistema registra la transazione,
     * aggiorna lo stato dell'opera e mostra la conferma all'utente.
     *
     * Espone tutti i dati dell'EOrdine (già persistito e con ID assegnato)
     * per permettere al template di mostrare un riepilogo completo della ricevuta:
     * numero ordine, data, metodo di pagamento, indirizzo di spedizione e importi.
     *
     * @param EOrdine $ordine L'ordine appena creato e persistito dal Control
     */
   

    // =========================================================================
    //  UC3 — Step 3a/3b: L'utente clicca "Fai un'offerta" — flusso alternativo
    // =========================================================================

    /**
     * Mostra il modulo per inserire una proposta di acquisto alternativa.
     *
     * Corrisponde al passo 3b dell'UC3 (flusso alternativo): il sistema mostra
     * un modulo per l'inserimento della cifra proposta e di una nota facoltativa.
     *
     * Mostra anche il prezzo originale dell'artista affinché l'utente possa
     * formulare un'offerta consapevole.
     *
     * @param EOpera      $opera          L'opera per cui si sta formulando l'offerta
     * @param string|null $errore         Eventuale codice di errore (es. dalla validazione
     *                                    di un invio precedente andato male)
     * @param array       $datiPrecedenti Dati già inseriti, per ripopolare il form dopo errore
     */
    public function mostraModuloOfferta(
        EOpera  $opera,
        ?string $errore = null,
        array   $datiPrecedenti = []
    ): void {
       if (USession::getInstance()->esisteValore('utente_loggato')) {
    $this->smarty->assign('userlogged', 'loggato');
}

        $this->smarty->assign('opera',   $opera);
        $this->smarty->assign('artista', $opera->getArtista());

        // Prezzo originale: visibile nel form per aiutare l'utente a orientarsi
        $this->smarty->assign('prezzoOriginale', $opera->getPrezzo());

        // Copertina per il contesto visivo nel form
        $immagini  = $opera->getImmagini();
        $copertina = !empty($immagini) ? $immagini[0] : null;
        list($mime, $b64) = $this->codificaImmagine($copertina, 'opera');
        $this->smarty->assign('copertina', ['type' => $mime, 'pic64' => $b64]);

        // Ripopolamento campi dopo errore (pattern da VRegistrazione)
        if (!empty($datiPrecedenti)) {
            $this->smarty->assign('datiForm', $datiPrecedenti);
        }

        // Gestione errori di validazione del form offerta
        if ($errore !== null) {
            switch ($errore) {
                case 'cifra_non_valida':
                    $this->smarty->assign('erroreOfferta', 'La cifra proposta deve essere un valore numerico maggiore di zero.');
                    break;

                case 'cifra_troppo_bassa':
                    $this->smarty->assign('erroreOfferta', 'La cifra proposta è troppo bassa. L\'artista potrebbe non prenderla in considerazione.');
                    break;

                case 'campo_mancante':
                    $this->smarty->assign('erroreOfferta', 'Inserisci una cifra per poter inviare la proposta.');
                    break;

                default:
                    $this->smarty->assign('erroreOfferta', 'Si è verificato un errore. Riprova.');
                    break;
            }
        }

        $this->smarty->display('modulo_offerta.tpl');
    }

    // =========================================================================
    //  UC3 — Step 4a/4b: L'utente invia la proposta — conferma offerta
    // =========================================================================

    /**
     * Mostra la pagina di conferma dopo l'invio della proposta d'offerta.
     *
     * Corrisponde al passo 4b dell'UC3: il sistema inoltra la proposta all'artista
     * e conferma l'invio all'utente.
     *
     * Mostra il riepilogo dell'offerta inviata (cifra, opera, nota se presente)
     * così l'utente ha evidenza di quello che ha inviato.
     *
     * @param EOfferta $offerta L'offerta appena creata e persistita dal Control
     */
    public function mostraConfermaInvioOfferta(EOfferta $offerta): void
    {
        if (USession::getInstance()->esisteValore('utente_loggato')) {
    $this->smarty->assign('userlogged', 'loggato');
}

        // Dati dell'offerta per il riepilogo
        $this->smarty->assign('offerta', $offerta);
        $this->smarty->assign('opera',   $offerta->getOpera());
        $this->smarty->assign('artista', $offerta->getOpera()->getArtista());

        // Copertina dell'opera per il contesto visivo della conferma
        $immagini  = $offerta->getOpera()->getImmagini();
        $copertina = !empty($immagini) ? $immagini[0] : null;
        list($mime, $b64) = $this->codificaImmagine($copertina, 'opera');
        $this->smarty->assign('copertina', ['type' => $mime, 'pic64' => $b64]);

        $this->smarty->assign(
            'messaggioInfo',
            'La tua proposta è stata inviata all\'artista. '
            . 'Riceverai una notifica via email quando l\'offerta sarà accettata o rifiutata.'
        );

        $this->smarty->display('conferma_offerta.tpl');
    }

    // =========================================================================
    //  Gestione errori trasversali al flusso
    // =========================================================================

    /**
     * Mostra un messaggio di errore in qualsiasi punto del flusso di compravendita.
     *
     * Chiavi gestite:
     *  - 'opera_non_trovata'       → l'ID non corrisponde ad alcuna opera nel DB
     *  - 'opera_non_disponibile'   → l'opera è già stata venduta (race condition)
     *  - 'dati_mancanti'           → campi obbligatori del form non compilati
     *  - 'metodo_pagamento_assente'→ metodo di pagamento non selezionato
     *  - 'utente_non_trovato'      → errore di sessione / utente non più valido
     *  - 'errore_persistenza'      → store() ha restituito null (errore DB)
     *  - 'errore_generico'         → fallback per errori non classificati
     *
     * @param string $codiceErrore Chiave semantica dell'errore
     */
    public function mostraErrore(string $codiceErrore): void
    {
        if (USession::getInstance()->esisteValore('utente_loggato')) {
    $this->smarty->assign('userlogged', 'loggato');
}

        switch ($codiceErrore) {
            case 'opera_non_trovata':
                $this->smarty->assign('errore', 'L\'opera richiesta non è stata trovata.');
                break;

            case 'opera_non_disponibile':
                // Race condition: un altro utente ha acquistato l'opera nel frattempo
                $this->smarty->assign(
                    'errore',
                    'Ci dispiace, quest\'opera non è più disponibile: è stata acquistata da un altro utente. '
                    . 'Esplora il catalogo per scoprire altre opere.'
                );
                break;

            case 'dati_mancanti':
                $this->smarty->assign('errore', 'Tutti i campi obbligatori devono essere compilati prima di procedere.');
                break;

            case 'metodo_pagamento_assente':
                $this->smarty->assign('errore', 'Seleziona un metodo di pagamento per completare l\'acquisto.');
                break;

            case 'utente_non_trovato':
                // Sessione scaduta o corrotta: invitiamo al re-login
                $this->smarty->assign(
                    'errore',
                    'Si è verificato un problema con la tua sessione. Effettua nuovamente il login e riprova.'
                );
                break;

            case 'errore_persistenza':
                $this->smarty->assign(
                    'errore',
                    'Si è verificato un errore durante il salvataggio dell\'ordine. '
                    . 'Non ti è stato addebitato nulla. Riprova tra qualche minuto.'
                );
                break;

            case 'errore_generico':
            default:
                $this->smarty->assign('errore', 'Si è verificato un errore imprevisto. Riprova più tardi.');
                break;
        }

        $this->smarty->display('errore_compravendita.tpl');
    }

    // =========================================================================
    //  Helper privati
    // =========================================================================

    /**
     * Codifica una singola immagine in Base64, con fallback all'immagine di default.
     *
     * Segue il pattern consolidato di VOpera, VRegistrazione e VCatalogo.
     *
     * @param mixed  $immagine    Oggetto EImmagine (getData(), getType()) oppure null
     * @param string $tipoDefault Contesto: 'opera' | 'avatar'
     * @return array              [string $mimeType, string $base64Data]
     */
    private function codificaImmagine($immagine, string $tipoDefault): array
{
    if (isset($immagine) && $immagine !== null) {
        $dati = $immagine->getData();
        if ($dati !== null) {
            $b64  = base64_encode($dati);
            $mime = $immagine->getType();
        } else {
            $percorso  = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/img/default_opera.png';
            $contenuto = file_get_contents($percorso);
            $b64       = base64_encode($contenuto !== false ? $contenuto : '');
            $mime      = 'image/png';
        }
    } else {
        $nomeDefault = ($tipoDefault === 'avatar')
            ? 'default_avatar.png'
            : 'default_opera.png';

        $percorso  = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/img/' . $nomeDefault;
        $contenuto = file_get_contents($percorso);
        $b64       = base64_encode($contenuto !== false ? $contenuto : '');
        $mime      = 'image/png';
    }

    return [$mime, $b64];
}
public function mostraConfermaOrdine(EOpera $opera, EUtente $utente): void {
    if (USession::getInstance()->esisteValore('utente_loggato')) {
        $this->smarty->assign('userlogged', 'loggato');
    }

    $this->smarty->assign('opera',  $opera);
    $this->smarty->assign('utente', $utente);

    $immagini  = $opera->getImmagini();
    $copertina = !empty($immagini) ? $immagini[0] : null;
    list($mime, $b64) = $this->codificaImmagine($copertina, 'opera');
    $this->smarty->assign('copertina', ['type' => $mime, 'pic64' => $b64]);

    $this->smarty->display('ConfermaOrdine.tpl');
}
}
?>