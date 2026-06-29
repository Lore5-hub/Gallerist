<?php
// Control/CCompravendita.php

/**
 * Classe di controllo dedicata alla gestione degli ordini e delle offerte d'acquisto (UC3).
 * @package Control
 */
class CCompravendita {

    /**
     * Operazione di sistema (Step 1): L'utente clicca su "Acquista".
     * Il sistema verifica la sessione e prepara la schermata di riepilogo.
     *
     * @param int $idOpera Identificativo dell'opera da comprare
     */
    public function avviaAcquisto(int $idOpera): void {
    $view = new VCompravendita();

    // 1. Verifica sessione
    $utente = USession::getInstance()->getValore('utente_loggato');
    if ($utente === null) {
        USession::getInstance()->setValue('redirect_dopo_login', "/Gallerist/compravendita/avviaAcquisto/$idOpera");
        header('Location: /Gallerist/utente/login');
        exit;
    }

    // 2. Carica solo l'opera dal DB — l'utente è già in sessione
    $opera = FPersistentManager::load('EOpera', 'id', $idOpera);

    if ($opera === null) {
        $view->mostraErrore('opera_non_trovata');
        return;
    }

    // 3. Verifica che l'opera sia acquistabile
    if (!($opera->getStatoOpera() instanceof EStatoInVendita)) {
        $view->mostraErrore('opera_non_disponibile');
        return;
    }

    // 4. Prezzo spedizione
    $prezzoSpedizione = new EPrezzo(5.00);

    // 5. Mostra riepilogo
    $view->mostraRiepilogoOrdine($utente, $opera, $prezzoSpedizione);
}

    /**
     * Operazione di sistema (Step 2): L'utente conferma il pagamento dell'acquisto diretto.
     *
     * @param int    $idOpera              Identificativo dell'opera acquistata
     * @param string $metodoPagamento      Metodo scelto (es. 'carta', 'paypal')
     * @param string $indirizzoSpedizione  Indirizzo di consegna inserito nel form
     * @param string $costoSpedizione      Costo di spedizione come stringa dal form
     */
    public function confermaAcquisto(
        int    $idOpera,
        string $metodoPagamento     = '',
        string $indirizzoSpedizione = '',
        string $costoSpedizione     = '5.00'
    ): void {
        $view = new VCompravendita();

        // 1. Verifica sessione
        $emailUtente = USession::getInstance()->getValore('utente_loggato');
        if ($emailUtente === null) {
            USession::getInstance()->impostaValore('redirect_dopo_login', "/Gallerist/Compravendita/avviaAcquisto/$idOpera");
            header('Location: /Gallerist/Accesso/login');
            exit;
        }

        // 2. Caricamento utente e opera — CRUD standard: transitano dal Manager
        $utente = FPersistentManager::load('EUtente', 'email', $emailUtente);
        $opera  = FPersistentManager::load('EOpera', 'id', $idOpera);

        if ($utente === null || $opera === null) {
            $view->mostraErrore('opera_non_trovata');
            return;
        }

        // 3. Validazione dati form
        if (empty(trim($metodoPagamento)) || empty(trim($indirizzoSpedizione))) {
            $view->mostraErrore('dati_mancanti');
            return;
        }

        // 4. Controllo anti-doppio acquisto (race condition):
        //    l'opera potrebbe essere stata acquistata da un altro utente nel frattempo
        if (!($opera->getStatoOpera() instanceof EStatoInVendita)) {
            $view->mostraErrore('opera_non_disponibile');
            return;
        }

        // 5. Costruzione dell'oggetto EOrdine
        //    EOrdine calcola totaleOrdine e commissionePiattaforma autonomamente nel costruttore
        $nuovoOrdine = new EOrdine(
            0,                                         // id: AUTO_INCREMENT sul DB
            new DateTimeImmutable(),                   // dataOrdine: adesso
            trim($metodoPagamento),
            trim($indirizzoSpedizione),
            new EPrezzo((float) $costoSpedizione),     // costoSpedizione
            $opera->getPrezzo(),                       // totaleArticolo: già EPrezzo
            new EPrezzo(0.0),                          // commissionePiattaforma: calcolata dal costruttore
            $utente,
            $opera
        );

        // 6. Persistenza ordine — CRUD standard: transita dal Manager
        $id = FPersistentManager::store($nuovoOrdine);
        if ($id === null) {
            error_log("CCompravendita::confermaAcquisto - FOrdine::store fallito per opera: $idOpera");
            $view->mostraErrore('errore_persistenza');
            return;
        }
        $nuovoOrdine->setId((int) $id);

        // 7. Aggiornamento stato opera a "venduta" — CRUD standard: transita dal Manager
        FPersistentManager::update('EOpera', 'statoOpera', 'Venduta', 'id', $idOpera);

        // 8. Notifica all'artista
        // TODO: UEmail::inviaEmail($opera->getArtista()->getEmail(), "Opera venduta!", "...")
        //       (UEmail non ancora implementata)

        // 9. Visualizzazione pagina di conferma
        $view->mostraConfermaOrdine($nuovoOrdine);
    }

    /**
     * Operazione di sistema (Step 3): L'utente richiede di formulare una proposta d'acquisto.
     *
     * @param int $idOpera Identificativo dell'opera
     */
    public function avviaPropostaOfferta(int $idOpera): void {
        $view = new VCompravendita();

        // 1. Verifica sessione
        $emailUtente = USession::getInstance()->getValore('utente_loggato');
        if ($emailUtente === null) {
            USession::getInstance()->impostaValore('redirect_dopo_login', "/Gallerist/Compravendita/avviaPropostaOfferta/$idOpera");
            header('Location: /Gallerist/Accesso/login');
            exit;
        }

        // 2. Caricamento opera — CRUD standard: transita dal Manager
        $opera = FPersistentManager::load('EOpera', 'id', $idOpera);
        if ($opera === null) {
            $view->mostraErrore('opera_non_trovata');
            return;
        }

        // 3. Verifica che l'opera sia in uno stato che accetta offerte
        if (!($opera->getStatoOpera() instanceof EStatoInVendita)) {
            $view->mostraErrore('opera_non_disponibile');
            return;
        }

        // 4. Mostra il modulo di inserimento offerta
        $view->mostraModuloOfferta($opera);
    }

    /**
     * Operazione di sistema (Step 4): L'utente invia formalmente la cifra proposta.
     *
     * @param int    $idOpera       Identificativo dell'opera
     * @param string $cifraProposta Cifra offerta come stringa dal form
     * @param string $nota          Nota facoltativa per l'artista
     */
    public function inviaPropostaOfferta(
        int    $idOpera,
        string $cifraProposta = '',
        string $nota          = ''
    ): void {
        $view = new VCompravendita();

        // 1. Verifica sessione
        $emailUtente = USession::getInstance()->getValore('utente_loggato');
        if ($emailUtente === null) {
            USession::getInstance()->impostaValore('redirect_dopo_login', "/Gallerist/Compravendita/avviaPropostaOfferta/$idOpera");
            header('Location: /Gallerist/Accesso/login');
            exit;
        }

        // 2. Caricamento utente e opera — CRUD standard: transitano dal Manager
        $utente = FPersistentManager::load('EUtente', 'email', $emailUtente);
        $opera  = FPersistentManager::load('EOpera', 'id', $idOpera);

        if ($utente === null || $opera === null) {
            $view->mostraErrore('opera_non_trovata');
            return;
        }

        // 3. Validazione cifra proposta
        $cifra = (float) $cifraProposta;
        if ($cifra <= 0) {
            $view->mostraModuloOfferta($opera, 'cifra_non_valida', [
                'cifraProposta' => $cifraProposta,
                'nota'          => $nota,
            ]);
            return;
        }

        // 4. Costruzione dell'oggetto EOfferta
        $nuovaOfferta = new EOfferta(
            0,                            // id: AUTO_INCREMENT sul DB
            new EPrezzo($cifra),          // cifraProposta: EPrezzo
            trim($nota),                  // nota: opzionale
            EOfferta::STATO_INVIATA,      // stato: costante, non stringa magica
            new DateTimeImmutable(),      // dataOfferta: DateTimeImmutable
            $utente,
            $opera
        );

        // 5. Persistenza della proposta — CRUD standard: transita dal Manager
        $id = FPersistentManager::store($nuovaOfferta);
        if ($id === null) {
            error_log("CCompravendita::inviaPropostaOfferta - FOfferta::store fallita per opera: $idOpera");
            $view->mostraErrore('errore_persistenza');
            return;
        }
        $nuovaOfferta->setId((int) $id);

        // 6. Notifica all'artista
        // TODO: UEmail::inviaEmail($opera->getArtista()->getEmail(), "Nuova offerta ricevuta", "...")
        //       (UEmail non ancora implementata)

        // 7. Visualizzazione messaggio di conferma
        $view->mostraConfermaInvioOfferta($nuovaOfferta);
}
}
?>