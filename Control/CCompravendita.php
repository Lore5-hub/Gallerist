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
    if ($utente->getRuolo() === EUtente::RUOLO_ADMIN) {
    header('Location: /Gallerist/Admin/dashboard');
    exit;
}
    // 2. Carica solo l'opera dal DB — l'utente è già in sessione
    $opera = FPersistentManager::load('EOpera', 'id', $idOpera);

    if ($opera === null) {
        $view->mostraErrore('opera_non_trovata');
        return;
    }
    if ($opera->getArtista()->getId() === $utente->getId()) {
    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera);
    exit;
}

    // 3. Verifica che l'opera sia acquistabile
    if (!($opera->getStatoOpera() instanceof EStatoInVendita)) {
        $view->mostraErrore('opera_non_disponibile');
        return;
    }
// Carica opere dell'artista per calcolare valutazione media
$opereArtista = FOpera::loadByArtista($opera->getArtista()->getId(), -1) ?? [];
$tuttiCommenti = [];
foreach ($opereArtista as $op) {
    $commentiOpera = FPersistentManager::load('ECommento', 'idOpera', $op->getId());
    if ($commentiOpera !== null) {
        if (!is_array($commentiOpera)) $commentiOpera = [$commentiOpera];
        foreach ($commentiOpera as $commento) {
            $tuttiCommenti[] = $commento;
            // ✅ Se è l'opera corrente, aggiungila anche ad essa
            if ($op->getId() === $opera->getId()) {
                $opera->addCommento($commento);
            }
        }
    }
}

// Calcola valutazione media dell'artista
if (count($tuttiCommenti) > 0) {
    $somma = array_reduce($tuttiCommenti, fn($carry, $c) => $carry + $c->getValutazione(), 0);
    $opera->getArtista()->setValutazioneMedia(round($somma / count($tuttiCommenti), 1));
}
    $artista = FPersistentManager::load('EArtista', 'id', $opera->getArtista()->getId());
if ($artista instanceof EArtista && count($tuttiCommenti) > 0) {
    $somma = array_reduce($tuttiCommenti, fn($carry, $c) => $carry + $c->getValutazione(), 0);
    $artista->setValutazioneMedia(round($somma / count($tuttiCommenti), 1));
}
// 4. Prezzo spedizione
    $prezzoSpedizione = new EPrezzo(5.00);

    // 5. Mostra riepilogo
    
    $view->mostraRiepilogoOrdine($utente, $opera, $prezzoSpedizione, $artista);
}

    /**
     * Operazione di sistema (Step 2): L'utente conferma il pagamento dell'acquisto diretto.
     *
     * @param int    $idOpera              Identificativo dell'opera acquistata
     * @param string $metodoPagamento      Metodo scelto (es. 'carta', 'paypal')
     * @param string $indirizzoSpedizione  Indirizzo di consegna inserito nel form
     * @param string $costoSpedizione      Costo di spedizione come stringa dal form
     */
    public function confermaAcquisto(int $idOpera): void {
    $view     = new VCompravendita();
    $sessione = USession::getInstance();

    $utente = $sessione->getValore('utente_loggato');
    if ($utente === null) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $opera = FPersistentManager::load('EOpera', 'id', $idOpera);
    if ($opera === null) {
        $view->mostraErrore('opera_non_trovata');
        return;
    }

    $db  = FDataBase::getInstance();
    $pdo = $db->getConnection();

    try {
        $pdo->beginTransaction();

        // Blocca solo la riga dell'opera — locking pessimistico a livello di riga
        $stmt = $pdo->prepare("SELECT stato FROM opera WHERE id = :id FOR UPDATE");
        $stmt->execute([':id' => $idOpera]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row || $row['stato'] !== 'in_vendita') {
            $pdo->rollBack();
            $view->mostraErrore('opera_non_disponibile');
            return;
        }

        // Aggiorna stato opera a Venduta
        $pdo->prepare("UPDATE opera SET stato = 'Venduta' WHERE id = :id")
            ->execute([':id' => $idOpera]);
// ✅ Leggi indirizzo dal form — può essere diverso da quello del profilo
$indirizzoSpedizione = trim($_POST['indirizzo_spedizione'] ?? $utente->getIndirizzo());
if (strlen($indirizzoSpedizione) < 10) {
    $pdo->rollBack();
    // Ricarica il riepilogo con errore
    $prezzoSpedizione = new EPrezzo(5.00);
    $view->mostraRiepilogoOrdine($utente, $opera, $prezzoSpedizione, null, 'Inserisci un indirizzo valido (almeno 10 caratteri).');
    return;
}
        // Salva ordine
        $ordine = new EOrdine(
            0,
            new DateTimeImmutable(),
            $_POST['metodo_pagamento'] ?? 'carta',
            
            $indirizzoSpedizione,
            new EPrezzo(5.00),
            $opera->getPrezzo(),
            new EPrezzo(0.0),
            $utente,
            $opera
        );
        $stmt = $pdo->prepare(
    "INSERT INTO ordine (data, idUtente, idOpera, tipo, indirizzo_spedizione, metodo_pagamento) 
     VALUES (:data, :idUtente, :idOpera, :tipo, :indirizzo, :metodo)"
);
$stmt->execute([
    ':data'     => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
    ':idUtente' => $utente->getId(),
    ':idOpera'  => $idOpera,
    ':tipo'     => 'diretto',
    ':indirizzo' => $indirizzoSpedizione,
    ':metodo'   => $_POST['metodo_pagamento'] ?? 'carta',
]);

        $pdo->commit();

    } catch (Exception $e) {
        $pdo->rollBack();
        $view->mostraErrore('errore_persistenza');
        return;
    }

    $view->mostraConfermaOrdine($opera, $utente);
}

    /**
     * Operazione di sistema (Step 3): L'utente richiede di formulare una proposta d'acquisto.
     *
     * @param int $idOpera Identificativo dell'opera
     */
    public function avviaPropostaOfferta(int $idOpera): void {
    $sessione = USession::getInstance();
    $view     = new VCompravendita();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente = $sessione->getValore('utente_loggato');

    // Carica opera e verifica che sia in vendita
    $opera = FPersistentManager::load('EOpera', 'id', $idOpera);
    if ($opera === null) {
        $view->mostraErrore('opera_non_trovata');
        return;
    }

    if (!($opera->getStatoOpera() instanceof EStatoInVendita)) {
        $view->mostraErrore('opera_non_disponibile');
        return;
    }

    // Valida il prezzo offerto
    $prezzoOfferto = (float)($_POST['prezzo_offerto'] ?? 0);
    $messaggio     = trim($_POST['messaggio'] ?? '');

    if ($prezzoOfferto <= 0) {
        header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera . '?errore=offerta_non_valida');
        exit;
    }
    if ($prezzoOfferto >= $opera->getPrezzo()->getValore()) {
    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera . '?errore=offerta_troppo_alta');
    exit;
}

    // Crea e salva l'offerta
    $offerta = new EOfferta(
        0,
        new EPrezzo($prezzoOfferto, 'EUR'),
        $messaggio,
        EOfferta::STATO_INVIATA,
        new DateTimeImmutable(),
        $utente,
        $opera
    );

    FOfferta::store($offerta);

    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera . '?offerta=inviata');
    exit;
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
        UEmail::inviaEmail(
            $opera->getArtista()->getEmail(),
            "Nuova offerta ricevuta per \"{$opera->getTitolo()}\"",
            UEmail::corpoNotificaNuovaOfferta(
                $opera->getArtista()->getNome(),
                $opera->getTitolo(),
                $cifra,
                $utente->getNickname(),
                trim($nota)
            )
        );

        // 7. Visualizzazione messaggio di conferma
        $view->mostraConfermaInvioOfferta($nuovaOfferta);
}

}
?>