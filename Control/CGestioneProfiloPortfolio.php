<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Profilo e Portfolio Artistico.
 * @package Control
 */
class CGestioneProfiloPortfolio {
    
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
    $tecniche  = FTecnica::loadAll() ?? [];   // ← aggiunta
    $vUtente = new VUtente();
    $vUtente->smarty->assign('categorie', $categorie);
    $vUtente->smarty->assign('tecniche', $tecniche);   // ← aggiunta
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
    $idCategoria, 
    $idTecnica    
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

        //  Crea ordine con tipo 'offerta'
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
        UEmail::inviaEmail(
    $offerta->getOfferente()->getEmail(),
    "La tua offerta è stata accettata - " . $offerta->getOpera()->getTitolo(),
    UEmail::corpoOffertaAccettata(
        $offerta->getOfferente()->getNome(),
        $offerta->getOpera()->getTitolo(),
        $offerta->getCifraProposta()->getValore()
    )
);
    }
}

    header('Location: /Gallerist/utente/profilo');
    exit;
}
}
?>