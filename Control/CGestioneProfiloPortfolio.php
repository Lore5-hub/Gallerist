<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Profilo e Portfolio Artistico.
 * @package Control
 */
class CGestionePortfolio {

    /**
     * Operazione di sistema: L'artista accede al proprio pannello di controllo (Dashboard).
     * Gestisce l'ingresso unico in cui l'artista può vedere sia il profilo che il portfolio.
     */
    public function mostraDashboard(): void {
        // 1. Identificazione dell'artista tramite la sessione attiva
        // TODO: Recuperare l'id o il nickname dell'artista loggato da Foundation\Session
        
        // 2. Recupero simultaneo dei dati del profilo e delle opere associate
        // Lo strato Foundation caricherà i dati dal DB inserendoli in oggetti Entity in RAM
        // TODO: Chiamare FArtista::load($idArtistaLoggato) in /Foundation
        // TODO: Chiamare FOpera::getOpereByArtista($idArtistaLoggato) in /Foundation
        
        // 3. Passaggio di entrambe le informazioni alla View per la renderizzazione del pannello
        // TODO: Includere e istanziare VPortfolio dalla cartella /View
        // TODO: Chiamare $VPortfolio->mostraPannelloArtista($datiArtista, $listaOpere)
    }

    /**
     * Operazione di sistema (Step 2a/2b): L'artista inserisce una nuova opera[cite: 66].
     * @param array $datiOpera Titolo, anno, tecnica, dimensioni, descrizione, categoria, tag, immagini[cite: 66].
     */
    public function aggiungiOpera(array $datiOpera): void {
        // 1. Controllo validità sessione come Artista
        // TODO: Controllo tramite Foundation\Session
        
        // 2. Creazione e salvataggio dell'oggetto EOpera e relative EImmagine
        // TODO: Gestire l'upload dei file (4 immagini, prima come copertina) [cite: 66]
        // TODO: Chiamare FOpera::store($nuovaOpera) per salvare le modifiche [cite: 67]
        // TODO: Chiamare FImmagine::store(...) per ogni immagine associata
        
        // 3. Chiedere all'artista se desidera metterla in vendita [cite: 67]
        // TODO: Chiamare VPortfolio->richiediOpzioneVendita($nuovaOpera->getId())
    }

    /**
     * Operazione di sistema (Step 3a/3b): L'artista sceglie di mettere in vendita l'opera[cite: 68].
     * @param int $idOpera ID dell'opera
     * @param float $prezzo Prezzo impostato dall'artista [cite: 68]
     */
    public function impostaInVendita(int $idOpera, float $prezzo): void {
        // 1. Aggiornamento stato dell'opera
        // TODO: FOpera::load($idOpera), $opera->setStato('In vendita'), $opera->setPrezzo($prezzo) [cite: 69]
        // TODO: FOpera::update($opera)
        
        // 2. Aggiornamento del profilo pubblico
        // TODO: VPortfolio->mostraConfermaPubblicazione() [cite: 69]
    }

    /**
     * Operazione di sistema (Flusso Alt. Step 4a/4b): L'artista replica a un commento[cite: 70, 71].
     * @param int $idCommento ID del commento a cui rispondere
     * @param string $testoReplica Il testo della risposta dell'artista
     */
    public function rispondiRecensione(int $idCommento, string $testoReplica): void {
        // TODO: Creare oggetto ERisposta o aggiornare ECommento
        // TODO: FCommento::salvaReplica($idCommento, $testoReplica)
        // TODO: Redirect alla View dell'opera per mostrare la risposta pubblicata [cite: 72]
    }

    /**
     * Operazione di sistema (Flusso Alt. Step 5a/5b): L'artista rimuove un'opera o il profilo[cite: 73].
     * @param int|null $idOpera Se null, si intende l'eliminazione dell'intero profilo.
     */
    public function rimuoviContenuto(?int $idOpera = null): void {
        // 1. Controllo identità e permessi tramite sessione
        // TODO: Recuperare l'artista dalla sessione
        
        if ($idOpera !== null) {
            // Eliminazione singola opera
            // TODO: FOpera::delete($idOpera)
        } else {
            // Eliminazione intero profilo
            // TODO: FArtista::delete($idArtistaAttivo)
            // TODO: Foundation\Session -> distruggi la sessione (Logout)
        }
        
        // 2. Conferma operazione [cite: 74]
        // TODO: Chiamare la View preposta per la conferma dell'avvenuta eliminazione
    }
    /**
     * Operazione di sistema: L'artista decide di rimuovere definitivamente il proprio profilo/account.
     * Questa è un'azione radicale che distrugge l'intera utenza.
     */
    public function eliminaProfilo(): void {
        // 1. Identificazione dell'utente da eliminare
        // TODO: Recuperare l'ID dell'artista loggato da Foundation\Session
        
        // 2. Rimozione fisica dal database dell'artista (e cancellazione a cascata di ciò che gli appartiene)
        // TODO: Chiamare FArtista::delete($idArtistaLoggato) nella cartella /Foundation
        
        // 3. Pulizia della sessione (effettua il logout forzato dell'utente appena cancellato)
        // TODO: Chiamare Foundation\Session::unsetUtente() o distruggere la sessione corrente
        
        // 4. Reindirizzamento dell'utente, ora anonimo, alla Homepage con messaggio di conferma
        // TODO: Includere e istanziare VHomepage dalla cartella /View
        // TODO: Chiamare $VHomepage->mostraHomeConMessaggio("Account eliminato con successo.")
    }
}
?>