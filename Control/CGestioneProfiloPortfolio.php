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
 * Mostra il form per aggiungere una nuova opera.
 * Risponde all'URL: /Gallerist/gestioneProfiloPortfolio/mostraFormOpera
 */
public function mostraFormOpera(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente = $sessione->getValore('utente_loggato');
    if ($utente->getRuolo() !== EUtente::RUOLO_ARTISTA) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }
    $categorie = FCategoria::loadAll() ?? [];
    $vUtente = new VUtente();
    $vUtente->smarty->assign('categorie', $categorie);
    $vUtente->smarty->display('FormOpera.tpl');
}

/**
 * Processa il form e salva la nuova opera nel DB.
 * Risponde all'URL: /Gallerist/gestioneProfiloPortfolio/salvaOpera
 */
public function salvaOpera(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $artista = $sessione->getValore('utente_loggato');
    if ($artista->getRuolo() !== EUtente::RUOLO_ARTISTA) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }

    // Raccolta dati dal form
    $titolo      = trim($_POST['titolo']      ?? '');
    $anno        = (int)($_POST['anno']       ?? 0);
    $tecnica     = trim($_POST['tecnica']     ?? '');
    $larghezza   = (float)($_POST['larghezza']  ?? 0);
    $altezza     = (float)($_POST['altezza']    ?? 0);
    $profondita  = (float)($_POST['profondita'] ?? 0);
    $unitaMisura = trim($_POST['unita_misura'] ?? 'cm');
    $descrizione = trim($_POST['descrizione'] ?? '');
    $categoria   = trim($_POST['categoria']   ?? '');
    $tags        = trim($_POST['tags']        ?? '');
    $inVendita   = isset($_POST['in_vendita']);
    $prezzo      = (float)($_POST['prezzo']   ?? 0);

    // Dimensioni come stringa unica
    $dimensioni = $larghezza . 'x' . $altezza . ' ' . $unitaMisura;

    // Stato opera
    $statoOpera = $inVendita ? new EStatoInVendita() : new EStatoInserito();
    $prezzoObj  = new EPrezzo($inVendita ? $prezzo : 0, 'EUR');

    // Recupera gli ID reali da DB
$idCategoria = FCategoria::getIdByNome($categoria);
$idTecnica   = FTecnica::getIdByNome($tecnica);

$opera = new EOpera(
    0, $titolo, $anno,
    new ETecnica(0, $tecnica),
    $dimensioni,
    $descrizione,
    $prezzoObj,
    $statoOpera,
    $artista,
    new ECategoria($categoria),
    $larghezza,
    $altezza,
    $profondita,
    $unitaMisura,
    $idCategoria, // ← reale
    $idTecnica    // ← reale
);

    // Salva nel DB
    $idOpera = FPersistentManager::store($opera);

    if ($idOpera === null) {
        $vUtente = new VUtente();
        $vUtente->smarty->assign('errori', ['generale' => 'Errore nel salvataggio dell\'opera.']);
        $vUtente->smarty->display('FormOpera.tpl');
        return;
    }

    // Gestione upload immagini
    if (isset($_FILES['immagini_opera']) && !empty($_FILES['immagini_opera']['name'][0])) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/uploads/opere/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach ($_FILES['immagini_opera']['tmp_name'] as $index => $tmpPath) {
            if ($_FILES['immagini_opera']['error'][$index] === UPLOAD_ERR_OK) {
                $estensione   = strtolower(pathinfo($_FILES['immagini_opera']['name'][$index], PATHINFO_EXTENSION));
                $nomeFile     = md5(time() . $index) . '.' . $estensione;
                $percorsoDest = $uploadDir . $nomeFile;

                if (move_uploaded_file($tmpPath, $percorsoDest)) {
                    $immagine = new EImmagine(0, $nomeFile);
                    FImmagine::store($immagine, (int)$idOpera);
                }
            }
        }
    }

    // Salva tag se presenti
    if (!empty($tags)) {
        foreach (explode(',', $tags) as $nomeTag) {
            $nomeTag = trim($nomeTag);
            if (!empty($nomeTag)) {
                $tag = new ETag(0, $nomeTag);
                FTag::store($tag, (int)$idOpera);
            }
        }
    }

    header('Location: /Gallerist/utente/profilo?opera=aggiunta');
    exit;
}
/**
 * Elimina un'opera dal portfolio dell'artista.
 * Risponde all'URL: /Gallerist/gestioneProfiloPortfolio/eliminaOpera
 */
public function eliminaOpera(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $artista = $sessione->getValore('utente_loggato');
    if ($artista->getRuolo() !== EUtente::RUOLO_ARTISTA) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }

    $idOpera = (int)($_POST['id_opera'] ?? 0);
    if ($idOpera === 0) {
        header('Location: /Gallerist/utente/profilo');
        exit;
    }

    // Verifica che l'opera appartenga all'artista loggato
    $opera = FPersistentManager::load('EOpera', 'id', $idOpera);
    if (!$opera instanceof EOpera || $opera->getArtista()->getId() !== $artista->getId()) {
        header('Location: /Gallerist/utente/profilo');
        exit;
    }

    FPersistentManager::delete('EOpera', 'id', $idOpera);

    header('Location: /Gallerist/utente/profilo?opera=eliminata');
    exit;
}

/**
 * Elimina il profilo dell'artista.
 * Risponde all'URL: /Gallerist/gestioneProfiloPortfolio/eliminaProfilo
 */
public function eliminaProfilo(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $artista = $sessione->getValore('utente_loggato');
    if ($artista->getRuolo() !== EUtente::RUOLO_ARTISTA) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }

    $id = $artista->getId();

    // Elimina artista e utente dal DB
    FPersistentManager::delete('EArtista', 'idUtente', $id);
    FPersistentManager::delete('EUtente',  'id',       $id);

    // Distruggi la sessione
    $sessione->distruggi();

    header('Location: /Gallerist/');
    exit;
}
public function rispondiOfferta(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $idOfferta = (int)($_POST['id_offerta'] ?? 0);
    $risposta  = trim($_POST['risposta']    ?? '');

    if ($idOfferta === 0 || !in_array($risposta, ['accettata', 'rifiutata'])) {
        header('Location: /Gallerist/utente/profilo');
        exit;
    }

    // Aggiorna stato offerta
    FOfferta::update('stato', $risposta, 'id', $idOfferta);

    // Se accettata, aggiorna stato opera a venduta
    if ($risposta === 'accettata') {
    $offerta = FOfferta::loadByField('id', $idOfferta);
    if ($offerta instanceof EOfferta) {
        $db = FDataBase::getInstance();
        
        // Aggiorna stato opera a Venduta
        $db->queryDB(
            "UPDATE opera SET stato = 'Venduta' WHERE id = :id",
            [':id' => $offerta->getOpera()->getId()]
        );

        // ✅ Crea ordine con tipo 'offerta'
        $ordine = new EOrdine(
            0,
            new DateTimeImmutable(),
            'offerta_accettata',
            $offerta->getOfferente()->getIndirizzo(),
            new EPrezzo(5.00),
            $offerta->getCifraProposta(),
            new EPrezzo(0.0),
            $offerta->getOfferente(),
            $offerta->getOpera(),
            'offerta'  // ← tipo offerta
        );
        FPersistentManager::store($ordine);
    }
}

    header('Location: /Gallerist/utente/profilo');
    exit;
}
}
?>