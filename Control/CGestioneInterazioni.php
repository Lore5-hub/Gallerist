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
    public function inserisciSegnalazione(array $datiSegnalazione): void {
        // 1. Identificazione dell'utente segnalante tramite la sessione attiva 
        if (!FSession::isLogged()) {
            header('Location: /login');
            exit;
        }
        
        $idUtenteSessione = FSession::getId();
        $nuovaSegnalazione = null;
        
        // 2. Controllo del tipo di target per la logica di business
        if ($datiSegnalazione['tipo_target'] === 'opera') {
            // L'utente sta segnalando un'opera d'arte inappropriata o con copyright violato
            $nuovaSegnalazione = new ESegnalazioneOpera(
                $datiSegnalazione['categoria'], 
                $datiSegnalazione['nota'], 
                $datiSegnalazione['id_target'], 
                $idUtenteSessione
            );
        } else {
            // L'utente sta segnalando un profilo utente/artista per comportamenti scorretti [cite: 53, 54]
            $nuovaSegnalazione = new ESegnalazioneUtente(
                $datiSegnalazione['categoria'], 
                $datiSegnalazione['nota'], 
                $datiSegnalazione['id_target'], 
                $idUtenteSessione
            );
        }
        
        // 3. Persistenza nel database tramite lo strato Foundation
        // Entrambe le segnalazioni finiranno nel pannello di moderazione dell'amministratore [cite: 57, 95, 96]
        FSegnalazione::store($nuovaSegnalazione);
        
        // 4. Feedback visivo di presa in carico e reindirizzamento 
        $view = new VInterazioni();
        $view->mostraConfermaInvioSegnalazione();
    }
}
?>