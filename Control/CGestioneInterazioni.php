<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Interazioni (Recensioni e Segnalazioni).
 * @package Control
 */
class CGestioneInterazioni {

    /**
     * Operazione di sistema: L'utente filtra le interazioni o seleziona una categoria specifica[cite: 56].
     * Permette di navigare tra commenti/recensioni filtrati per macro-area o tipo di contenuto.
     * @param string $categoria La categoria o classificazione selezionata [cite: 56]
     */
    public function scegliPerCategoria(string $categoria): void {
        // 1. Interrogazione del livello di persistenza per ottenere elementi associati alla categoria
        // Recuperiamo i commenti filtrati (puoi adattarlo se usi FRecensione o una chiamata combinata)
        $elementiFiltrati = FCommento::getByCategoria($categoria);
        
        // 2. Passaggio dei dati alla View per l'aggiornamento dinamico dell'interfaccia
        $view = new VInterazioni();
        $view->mostraContenutiFiltrati($elementiFiltrati);
    }

    /**
     * Operazione di sistema: L'utente inserisce un commento testuale sotto un'opera.
     * Gestisce la pura interazione sociale/discussione tra utenti senza votazione numerica.
     * @param array $datiCommento Contiene 'testo', 'id_opera' 
     */
    public function inserisciCommento(array $datiCommento): void {
        // 1. Controllo dello stato dell'utente (deve essere autenticato) 
        if (!FSession::isLogged()) {
            header('Location: /login');
            exit;
        }
        
        // Recupero il nickname o l'ID dell'utente dalla sessione attiva
        $idUtenteSessione = FSession::getId();
        
        // 2. Istanziazione dell'oggetto Entity ECommento in memoria RAM
        $nuovoCommento = new ECommento($datiCommento['testo'], $idUtenteSessione, $datiCommento['id_opera']);
        
        // 3. Salvataggio del commento nel database
        FCommento::store($nuovoCommento);
        
        // 4. Aggiornamento della View dell'opera per mostrare il nuovo commento nella discussione [cite: 25, 26]
        $view = new VOpera();
        $view->mostraSchedaDettaglio($datiCommento['id_opera']);
    }

    /**
     * Operazione di sistema: L'utente rilascia una recensione formale sul lavoro di un artista[cite: 45, 48].
     * Include obbligatoriamente una valutazione quantitativa (es. stelle da 1 a 5) e un testo[cite: 50, 51].
     * @param array $datiRecensione Contiene 'testo', 'valutazione', 'id_opera', 'id_artista' [cite: 50]
     */
    public function inserisciRecensione(array $datiRecensione): void {
        // 1. Verifica dei permessi di sessione (l'utente deve essere loggato) 
        if (!FSession::isLogged()) {
            header('Location: /login');
            exit;
        }
        
        $idUtenteSessione = FSession::getId();
        $idArtista = $datiRecensione['id_artista']; // Assumiamo che la View passi anche l'ID dell'autore dell'opera 
        
        // Regola di business: un artista non può recensire se stesso!
        if (FSession::getRuolo() === 'Artista' && $idUtenteSessione === $idArtista) {
            // Reindirizziamo alla pagina dell'opera con un messaggio di errore
            header('Location: /opera/' . $datiRecensione['id_opera'] . '?error=self_review');
            exit;
        }
        
        // 2. Creazione dell'oggetto Entity ERecensione in RAM
        $nuovaRecensione = new ERecensione($datiRecensione['testo'], $datiRecensione['valutazione'], $idUtenteSessione, $datiRecensione['id_opera']);
        
        // 3. Persistenza della recensione nel DB
        FRecensione::store($nuovaRecensione);
        
        // 4. Ricalcolo immediato della valutazione media globale dell'artista 
        FArtista::aggiornaRatingMedio($idArtista);
        
        // 5. Notifica di successo e ricaricamento della pagina dell'opera aggiornata [cite: 25, 26]
        $view = new VOpera();
        $view->mostraSchedaDettaglio($datiRecensione['id_opera']);
    }

    /**
     * Operazione di sistema: L'utente invia una segnalazione di violazione[cite: 45, 53].
     * Può essere invocata sia dalla pagina di un'opera che dal profilo di un artista.
     * @param array $datiSegnalazione Contiene:
     * - 'tipo_target': string ('opera' o 'utente') 
     * - 'id_target': int/string (ID dell'opera o nickname dell'utente) 
     * - 'categoria': string (il caso specifico selezionato per categoria) [cite: 56]
     * - 'nota': string (nota facoltativa inserita dall'utente) [cite: 56]
     */
    public function inviaSegnalazione(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $segnalante  = $sessione->getValore('utente_loggato');
    $idSegnalato = (int)($_POST['id_segnalato']     ?? 0);
    $tipo        = trim($_POST['tipo_segnalazione'] ?? '');
    $descrizione = trim($_POST['descrizione']        ?? '');

    if ($idSegnalato === 0 || empty($tipo) || empty($descrizione)) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }

    $segnalazione = new ESegnalazione(
        0,                          // id → AUTO_INCREMENT
        $descrizione,               // motivo
        '',                         // notaOpzionale
        new DateTimeImmutable(),    // dataSegnalazione
        $tipo,                      // tipoTarget
        $idSegnalato,               // idTarget
        $segnalante->getId()        // idSegnalatore
    );

    FPersistentManager::store($segnalazione);

    header('Location: /Gallerist/catalogo/visualizzaProfiloArtista/' . $idSegnalato . '?segnalazione=inviata');
    exit;
}
}
?>