<?php
require_once __DIR__ . '/../Foundation/FUtente.php';
require_once __DIR__ . '/../Foundation/FOpera.php';
// require_once __DIR__ . '/../Foundation/FOrdine.php';
// require_once __DIR__ . '/../Foundation/FOfferta.php';
require_once __DIR__ . '/../Entity/EOrdine.php';
require_once __DIR__ . '/../Entity/EOfferta.php';
require_once __DIR__ . '/../Entity/EPrezzo.php';
// require_once __DIR__ . '/../Utility/USession.php';
// require_once __DIR__ . '/../Utility/UEmail.php';
// require_once __DIR__ . '/../View/VCompravendita.php';

/**
 * Classe di controllo dedicata alla gestione degli ordini e delle offerte d'acquisto.
 * @package Control
 */
class CCompravendita {

    /**
     * Operazione di sistema (Step 1): L'utente clicca su "Acquista".
     * Il sistema prepara la schermata di riepilogo con i dati dell'utente loggato.
     *
     * @param int $idOpera Identificativo dell'opera da comprare
     */
    public function avviaAcquisto(int $idOpera): void {
        // 1. Verifica sessione utente loggato
        // TODO: $emailUtente = USession::getInstance()->leggiValore('utente_loggato')
        //       if ($emailUtente === null) { redirect login }

        // 2. Caricamento utente e opera tramite Foundation
        $utente = FUtente::loadByField('email', $emailUtente ?? '');
        $opera  = FOpera::loadByField('id', $idOpera);

        if ($utente === null || $opera === null) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Dati non trovati.")
            return;
        }

        // 3. Prezzo di spedizione predefinito wrappato in EPrezzo per coerenza col dominio
        $prezzoSpedizione = new EPrezzo(5.00);

        // 4. Mostra modulo di riepilogo con indirizzo precompilato
        // TODO: Instanziare VCompravendita e chiamare $view->mostraRiepilogoOrdine($utente, $opera, $prezzoSpedizione)
    }

    /**
     * Operazione di sistema (Step 2): L'utente conferma il pagamento dell'acquisto diretto.
     *
     * @param int   $idOpera   Identificativo dell'opera acquistata
     * @param array $datiForm  Dati dal form: 'metodoPagamento', 'indirizzoSpedizione', 'costoSpedizione'
     */
    public function confermaAcquisto(int $idOpera, array $datiForm): void {
        // 1. Verifica sessione e caricamento oggetti
        // FIX: utente e opera vengono caricati PRIMA di essere usati
        // TODO: $emailUtente = USession::getInstance()->leggiValore('utente_loggato')
        //       if ($emailUtente === null) { redirect login }

        $utente = FUtente::loadByField('email', $emailUtente ?? '');
        $opera  = FOpera::loadByField('id', $idOpera);

        if ($utente === null || $opera === null) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Dati non trovati.")
            return;
        }

        // 2. Validazione dati form
        if (empty($datiForm['metodoPagamento']) || empty($datiForm['indirizzoSpedizione'])) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Dati mancanti.")
            return;
        }

        // 3. Controllo anti-doppio acquisto: l'opera potrebbe essere stata
        // acquistata da un altro utente nel tempo trascorso dalla pagina di riepilogo
        if ($opera->getStato() !== 'in_vendita') {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Ci dispiace, quest'opera non è più disponibile.")
            return;
        }

        // 4. Costruzione degli EPrezzo per i valori monetari
        // FIX: EOrdine vuole EPrezzo, non float — i calcoli (totale e commissione)
        // vengono eseguiti automaticamente dal costruttore di EOrdine,
        // quindi non vanno passati come parametri esterni
        $totaleArticolo  = $opera->getPrezzo();                                  // già EPrezzo
        $costoSpedizione = new EPrezzo((float) $datiForm['costoSpedizione']);

        // 5. Creazione dell'oggetto Entity Ordine
        // FIX: dataOrdine vuole DateTimeImmutable, non una stringa date()
        // FIX: totaleOrdine e commissione rimossi — EOrdine li calcola in autonomia
        //      nel costruttore tramite calcolaTotaleOrdine() e calcolaTrattenuta()
        $nuovoOrdine = new EOrdine(
            0,                            // id: AUTO_INCREMENT sul DB
            new DateTimeImmutable(),      // dataOrdine: adesso, con DateTimeImmutable
            $datiForm['metodoPagamento'],
            $datiForm['indirizzoSpedizione'],
            $costoSpedizione,
            $totaleArticolo,
            new EPrezzo(0.0),             // commissionePiattaforma: calcolata dal costruttore
            $utente,
            $opera
        );

        // 6. Persistenza ordine e aggiornamento stato opera
        // TODO: $id = FOrdine::store($nuovoOrdine)
        //       if ($id === null) { mostraErrore }
        //       $nuovoOrdine->setId((int) $id)
        // TODO: FOpera::update('stato', 'venduta', 'id', $idOpera)

        // 7. Notifica all'artista
        // TODO: UEmail::inviaEmail($opera->getArtista()->getEmail(), "Opera venduta!", "...")

        // 8. Visualizzazione pagina di conferma
        // TODO: Instanziare VCompravendita e chiamare $view->mostraConfermaOrdine($nuovoOrdine)
    }

    /**
     * Operazione di sistema (Step 3): L'utente richiede di effettuare una proposta d'acquisto.
     *
     * @param int $idOpera Identificativo dell'opera
     */
    public function avviaPropostaOfferta(int $idOpera): void {
        // Caricamento opera tramite Foundation
        $opera = FOpera::loadByField('id', $idOpera);

        if ($opera === null) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Opera non trovata.")
            return;
        }

        // TODO: Instanziare VCompravendita e chiamare $view->mostraModuloOfferta($opera)
    }

    /**
     * Operazione di sistema (Step 4): L'utente invia formalmente la cifra proposta.
     *
     * @param int   $idOpera      Identificativo dell'opera
     * @param array $datiOfferta  Dati dal form: 'cifraProposta', 'nota' (opzionale)
     */
    public function inviaPropostaOfferta(int $idOpera, array $datiOfferta): void {
        // 1. Verifica sessione e caricamento oggetti
        // TODO: $emailUtente = USession::getInstance()->leggiValore('utente_loggato')
        //       if ($emailUtente === null) { redirect login }

        $utente = FUtente::loadByField('email', $emailUtente ?? '');
        $opera  = FOpera::loadByField('id', $idOpera);

        if ($utente === null || $opera === null) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("Dati non trovati.")
            return;
        }

        // 2. Validazione cifra proposta
        // FIX: controllo che la cifra sia presente e positiva prima di creare l'Entity
        $cifra = (float) ($datiOfferta['cifraProposta'] ?? 0);
        if ($cifra <= 0) {
            // TODO: Instanziare VCompravendita e chiamare $view->mostraErrore("La cifra proposta deve essere maggiore di zero.")
            return;
        }

        // 3. Creazione dell'oggetto Entity Offerta
        // FIX: cifraProposta wrappata in EPrezzo (non più float grezzo)
        // FIX: dataOfferta come DateTimeImmutable (non più stringa date())
        // FIX: stato iniziale tramite costante EOfferta::STATO_INVIATA (non stringa magica)
        $nuovaOfferta = new EOfferta(
            0,                                        // id: AUTO_INCREMENT sul DB
            new EPrezzo($cifra),                      // cifraProposta: EPrezzo
            $datiOfferta['nota'] ?? '',               // nota: opzionale
            EOfferta::STATO_INVIATA,                  // stato: costante, non stringa magica
            new DateTimeImmutable(),                  // dataOfferta: DateTimeImmutable
            $utente,
            $opera
        );

        // 4. Persistenza della proposta
        // TODO: $id = FOfferta::store($nuovaOfferta)
        //       if ($id === null) { mostraErrore }
        //       $nuovaOfferta->setId((int) $id)

        // 5. Notifica all'artista
        // TODO: UEmail::inviaEmail($opera->getArtista()->getEmail(), "Nuova offerta ricevuta", "...")

        // 6. Visualizzazione messaggio di conferma
        // TODO: Instanziare VCompravendita e chiamare $view->mostraConfermaInvioOfferta()
    }
}
?>