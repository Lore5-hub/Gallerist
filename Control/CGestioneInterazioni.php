<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Interazioni (Recensioni e Segnalazioni).
 * @package Control
 */
class CGestioneInterazioni {

    /**
     * Operazione di sistema: L'utente filtra le interazioni o seleziona una categoria specifica.
     * Permette di navigare tra commenti/recensioni filtrati per macro-area o tipo di contenuto.
     * @param string $categoria La categoria o classificazione selezionata
     */
    public function scegliPerCategoria(string $categoria): void {
        // 1. Interrogazione del livello di persistenza per ottenere elementi associati alla categoria
        // Lo strato Foundation restituirà una collezione di oggetti Entity filtrati
        // TODO: Chiamare FCommento::getByCategoria($categoria) o FRecensione::getByCategoria($categoria) in /Foundation
        
        // 2. Passaggio dei dati alla View per l'aggiornamento dinamico dell'interfaccia
        // TODO: Includere e istanziare la View VInterazioni dalla cartella /View
        // TODO: Chiamare $VInterazioni->mostraContenutiFiltrati($elementiFiltrati)
    }

    /**
     * Operazione di sistema: L'utente inserisce un commento testuale sotto un'opera.
     * Gestisce la pura interazione sociale/discussione tra utenti senza votazione numerica.
     * @param array $datiCommento Contiene 'testo', 'id_opera'
     */
    public function inserisciCommento(array $datiCommento): void {
        // 1. Controllo dello stato dell'utente (deve essere autenticato)
        // TODO: Utilizzare Foundation\Session per verificare il login e ottenere il nickname dell'utente corrente
        
        // 2. Istanziazione dell'oggetto Entity ECommento in memoria RAM
        // $nuovoCommento = new ECommento($datiCommento['testo'], $idUtenteSessione, $datiCommento['id_opera']);
        
        // 3. Salvataggio del commento nel database
        // TODO: Chiamare FCommento::store($nuovoCommento) nella cartella /Foundation
        
        // 4. Aggiornamento della View dell'opera per mostrare il nuovo commento nella discussione
        // TODO: Includere e istanziare VOpera dalla cartella /View
        // TODO: Chiamare $VOpera->mostraSchedaDettaglio($datiCommento['id_opera'])
    }

    /**
     * Operazione di sistema: L'utente rilascia una recensione formale sul lavoro di un artista.
     * Include obbligatoriamente una valutazione quantitativa (es. stelle da 1 a 5) e un testo.
     * @param array $datiRecensione Contiene 'testo', 'valutazione', 'id_opera'
     */
    public function inserisciRecensione(array $datiRecensione): void {
        // 1. Verifica dei permessi di sessione (es. un artista non può recensire se stesso)
        // TODO: Utilizzare Foundation\Session per recuperare l'utente loggato
        
        // 2. Creazione dell'oggetto Entity ERecensione in RAM
        // $nuovaRecensione = new ERecensione($datiRecensione['testo'], $datiRecensione['valutazione'], $idUtenteSessione);
        
        // 3. Persistenza della recensione nel DB
        // TODO: Chiamare FRecensione::store($nuovaRecensione) nella cartella /Foundation
        
        // 4. Ricalcolo immediato della valutazione media globale dell'opera o dell'artista
        // TODO: Chiamare FArtista::aggiornaRatingMedio($idArtista) nella cartella /Foundation
        
        // 5. Notifica di successo e ricaricamento della pagina
        // TODO: Chiamare la View preposta per confermare l'inserimento della recensione
    }

    /**
     * Operazione di sistema: L'utente invia una segnalazione di violazione.
     * Può essere invocata sia dalla pagina di un'opera che dal profilo di un artista.
     * * @param array $datiSegnalazione Contiene:
     * - 'tipo_target': string ('opera' o 'utente')
     * - 'id_target': int/string (ID dell'opera o nickname dell'utente)
     * - 'categoria': string (il caso specifico selezionato per categoria)
     * - 'nota': string (nota facoltativa inserita dall'utente)
     */
    public function inserisciSegnalazione(array $datiSegnalazione): void {
        // 1. Identificazione dell'utente segnalante tramite la sessione attiva
        // TODO: Estrarre l'utente corrente da Foundation\Session per tracciare l'autore della segnalazione
        
        // 2. Controllo del tipo di target per la logica di business (Logica condizionale o Polimorfismo)
        if ($datiSegnalazione['tipo_target'] === 'opera') {
            // L'utente sta segnalando un'opera d'arte inappropriata o con copyright violato
            // $nuovaSegnalazione = new ESegnalazioneOpera($datiSegnalazione['categoria'], $datiSegnalazione['nota'], $datiSegnalazione['id_target']);
        } else {
            // L'utente sta segnalando un profilo utente/artista per comportamenti scorretti
            // $nuovaSegnalazione = new ESegnalazioneUtente($datiSegnalazione['categoria'], $datiSegnalazione['nota'], $datiSegnalazione['id_target']);
        }
        
        // 3. Persistenza nel database tramite lo strato Foundation
        // Entrambe le segnalazioni finiranno nel pannello di moderazione dell'amministratore
        // TODO: Chiamare FSegnalazione::store($nuovaSegnalazione) nella cartella /Foundation
        
        // 4. Feedback visivo di presa in carico e reindirizzamento
        // TODO: Includere e istanziare VInterazioni dalla cartella /View
        // TODO: Chiamare $VInterazioni->mostraConfermaInvioSegnalazione()
    }
}
?>