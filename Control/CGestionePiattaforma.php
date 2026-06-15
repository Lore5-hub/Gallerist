<?php

// Classe di controllo per l'amministratore (pannello di gestione e moderazione)
class CGestionePiattaforma {

    // Prende tutti gli artisti registrati nel sistema
    public function getListaArtisti() {
        // Mi collego alla classe Foundation per fare la query
        $fArtista = new FArtista();
        $lista = $fArtista->caricaTuttiGliArtisti();
        
        return $lista; 
    }

    // Cambia lo stato di un artista (approvato o rifiutato dopo controllo documenti)
    public function verificaArtista($idArtista, $note) {
        $fArtista = new FArtista();
        
        // Carico l'artista dal db, cambio le note e lo stato
        $artista = $fArtista->caricaInteroArtista($idArtista);
        if ($artista) {
            $artista->setBiografia($note); // o un metodo specifico per le note di validazione
            return $fArtista->aggiornaArtista($artista);
        }
        
        return false;
    }

    // Recupera le segnalazioni inviate dagli utenti (sui commenti o sulle opere)
    public function getSegnalazioni() {
        $fSegnalazione = new FSegnalazione();
        $segnalazioniAttive = $fSegnalazione->recuperaSegnalazioniInAttesa();
        
        return $segnalazioniAttive;
    }

    // Chiude e archivia una segnalazione risolta
    public function archivioSegnalazione($idSegnalazione) {
        $fSegnalazione = new FSegnalazione();
        
        // Cambia lo stato interno della segnalazione a "Risolta/Archiviata"
        $esito = $fSegnalazione->modificaStato($idSegnalazione, "Archiviata");
        return $esito;
    }

    // Applica un ban o una restrizione a un utente dopo una segnalazione
    public function restrizioni($idUtente, $tipoBan, $durata, $commentoAdmin, $idSegnalazione) {
        $fUtente = new FUtente();
        
        // Imposto il ban sull'utente nel database
        $banApplicato = $fUtente->bannaUtente($idUtente, $tipoBan, $durata);
        
        if ($banApplicato) {
            // Se il ban va a buon fine, archivio in automatico la segnalazione che lo ha causato
            $this->archivioSegnalazione($idSegnalazione);
            return true;
        }
        
        return false;
    }
}