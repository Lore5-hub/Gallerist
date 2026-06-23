<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Profilo e Portfolio Artistico.
 * @package Control
 */
class CGestioneProfiloPortfolio {

    /**
     * Operazione di sistema: L'artista accede al proprio pannello di controllo (Dashboard).
     * Gestisce l'ingresso unico in cui l'artista può vedere sia il profilo che il portfolio[cite: 64, 65].
     */
    public function mostraDashboard(): void {
        // 1. Identificazione dell'artista tramite la sessione attiva
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        $idArtistaLoggato = FSession::getId();
        
        // 2. Recupero simultaneo dei dati del profilo e delle opere associate
        $datiArtista = FArtista::load($idArtistaLoggato);
        $listaOpere = FOpera::getOpereByArtista($idArtistaLoggato);
        
        // 3. Passaggio di entrambe le informazioni alla View per la renderizzazione del pannello
        $view = new VPortfolio();
        $view->mostraPannelloArtista($datiArtista, $listaOpere);
    }

    /**
     * Operazione di sistema (Step 2a/2b): L'artista inserisce una nuova opera.
     * @param array $datiOpera Titolo, anno, tecnica, dimensioni, descrizione, categoria, tag, immagini.
     */
    public function aggiungiOpera(array $datiOpera): void {
        // 1. Controllo validità sessione come Artista
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        $idArtistaLoggato = FSession::getId();
        
        // 2. Creazione e salvataggio dell'oggetto EOpera in RAM
        // Raccoglie tutti i dettagli tecnici descritti nei requisiti (tecnica, dimensioni, ecc.) 
        $nuovaOpera = new EOpera(
            $datiOpera['titolo'],
            $datiOpera['anno_realizzazione'],
            $datiOpera['tecnica'],
            $datiOpera['dimensioni'], // Contiene larghezza, altezza, profondità e unità di misura 
            $datiOpera['descrizione'],
            $datiOpera['categoria'],
            $idArtistaLoggato,
            $datiOpera['tag'] ?? null
        );
        
        // Lo strato Foundation salva l'opera e restituisce l'ID appena generato dal database [cite: 67]
        $idNuovaOpera = FOpera::store($nuovaOpera);
        
        // Gestione dell'upload dei file (4 immagini richiamate dal caso d'uso) 
        if (isset($datiOpera['immagini']) && is_array($datiOpera['immagini'])) {
            foreach ($datiOpera['immagini'] as $index => $percorsoImmagine) {
                // La prima immagine del ciclo viene impostata come copertina principale (true) 
                $isCopertina = ($index === 0);
                $nuovaImmagine = new EImmagine($percorsoImmagine, $idNuovaOpera, $isCopertina);
                FImmagine::store($nuovaImmagine);
            }
        }
        
        // 3. Sistema interroga l'artista se desidera mettere immediatamente l'opera in vendita [cite: 67]
        $view = new VPortfolio();
        $view->richiediOpzioneVendita($idNuovaOpera);
    }

   /**
     * Operazione di sistema (Step 3a/3b): L'artista sceglie di mettere in vendita l'opera.
     * @param int $idOpera ID dell'opera
     * @param float $prezzo Valore numerico inserito nel form
     */
    public function impostaInVendita(int $idOpera, float $prezzo): void {
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        // 1. Aggiornamento stato e prezzo dell'opera
        $opera = FOpera::load($idOpera);
        
        // Controllo di sicurezza: l'opera deve esistere e deve appartenere all'artista loggato
        if ($opera && $opera->getIdArtista() === FSession::getId()) {
            $opera->setStato('In vendita');
            
            // TRASFORMAZIONE: Creiamo l'oggetto EPrezzo partendo dal float grezzo
            // (Nota: assumo che il costruttore di EPrezzo accetti il float come parametro)
            $oggettoPrezzo = new EPrezzo($prezzo);
            
            $opera->setPrezzo($oggettoPrezzo); // Ora passiamo l'oggetto EPrezzo
            FOpera::update($opera);
        }
        
        // 2. Aggiornamento del profilo pubblico
        $view = new VPortfolio();
        $view->mostraConfermaPubblicazione();
    }

    /**
     * Operazione di sistema (Flusso Alt. Step 4a/4b): L'artista replica a un commento.
     * @param int $idCommento ID del commento a cui rispondere
     * @param string $testoReplica Il testo della risposta dell'artista
     */
    public function rispondiRecensione(int $idCommento, string $testoReplica): void {
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        // Salvataggio della replica nel DB agganciandola al commento originale
        FCommento::salvaReplica($idCommento, $testoReplica); //[cite: 71]
        
        // Identifichiamo l'opera associata per ricaricare la pagina corretta con la risposta pubblicata [cite: 72]
        $idOpera = FCommento::getIdOperaByCommento($idCommento);
        
        $view = new VOpera();
        $view->mostraSchedaDettaglio($idOpera); //[cite: 72]
    }

    /**
     * Operazione di sistema (Flusso Alt. Step 5a/5b): L'artista rimuove un'opera o il profilo.
     * @param int|null $idOpera Se null, si intende l'eliminazione radicale dell'intero profilo.
     */
    public function rimuoviContenuto(?int $idOpera = null): void {
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        $idArtistaAttivo = FSession::getId();
        
        if ($idOpera !== null) {
            // Eliminazione di una singola opera dal portfolio 
            $opera = FOpera::load($idOpera);
            if ($opera && $opera->getIdArtista() === $idArtistaAttivo) {
                FOpera::delete($idOpera); //[cite: 74]
            }
            // Ricarica la dashboard con il portfolio aggiornato
            $this->mostraDashboard();
        } else {
            // Se l'ID dell'opera è nullo, l'artista ha scelto di cancellare l'intero profilo 
            $this->eliminaProfilo();
        }
    }

    /**
     * Operazione di sistema: L'artista decide di rimuovere definitivamente il proprio profilo/account.
     * Questa è un'azione radicale che distrugge l'intera utenza.
     */
    public function eliminaProfilo(): void {
        if (!FSession::isLogged() || FSession::getRuolo() !== 'Artista') {
            header('Location: /login');
            exit;
        }
        
        // 1. Identificazione dell'utente da eliminare
        $idArtistaLoggato = FSession::getId();
        
        // 2. Rimozione fisica dal database dell'artista (e cancellazione automatica a cascata nel DB delle sue opere)
        FArtista::delete($idArtistaLoggato);
        
        // 3. Pulizia della sessione (effettua il logout forzato dell'utente appena cancellato)
        FSession::unsetUtente();
        
        // 4. Reindirizzamento dell'utente, ora anonimo, alla Homepage con messaggio di conferma [cite: 74]
        $view = new VHomepage();
        $view->mostraHomeConMessaggio("Account eliminato con successo."); //[cite: 74]
    }
}
?>