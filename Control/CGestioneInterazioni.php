<?php
/**
 * Classe di controllo per il Caso d'Uso: Gestione Interazioni (Recensioni e Segnalazioni).
 * @package Control
 */
class CGestioneInterazioni {

    

    

    /**
     * Operazione di sistema: L'utente invia una segnalazione di violazione.
     * Può essere invocata sia dalla pagina di un'opera che dal profilo di un artista.
     * @param array $datiSegnalazione Contiene:
     * - 'tipo_target': string ('opera' o 'utente') 
     * - 'id_target': int/string (ID dell'opera o nickname dell'utente) 
     * - 'categoria': string (il caso specifico selezionato per categoria) 
     * - 'nota': string (nota facoltativa inserita dall'utente) 
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
    if ($tipo === 'Commento') {
    $commento = FPersistentManager::load('ECommento', 'id', $idSegnalato);
    if ($commento instanceof ECommento && $commento->getAutore()->getId() === $segnalante->getId()) {
        header('Location: /Gallerist/catalogo/esploraCatalogo?errore=segnalazione_propria');
        exit;
    }
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

//  Redirect corretto in base al tipo
if ($tipo === 'Opera') {
    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idSegnalato . '?segnalazione=inviata');
} elseif ($tipo === 'Commento') {
    header('Location: /Gallerist/catalogo/esploraCatalogo?segnalazione=inviata');
} else {
    // Profilo
    header('Location: /Gallerist/catalogo/visualizzaProfiloArtista/' . $idSegnalato . '?segnalazione=inviata');
}
exit;
}
public function salvaRecensione(): void {
    $sessione = USession::getInstance();

    if (!$sessione->esisteValore('utente_loggato')) {
        header('Location: /Gallerist/utente/login');
        exit;
    }

    $utente     = $sessione->getValore('utente_loggato');
    if ($utente->getRuolo() === EUtente::RUOLO_ADMIN) {
    header('Location: /Gallerist/Admin/dashboard');
    exit;
}
    $idOpera    = (int)($_POST['id_opera']    ?? 0);
    $valutazione = (int)($_POST['valutazione'] ?? 0);
    $commento   = trim($_POST['commento']     ?? '');

    if ($idOpera === 0 || $valutazione < 1 || $valutazione > 5 || empty($commento)) {
        header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera);
        exit;
    }

    // Carica opera e utente come oggetti
    $opera   = FPersistentManager::load('EOpera', 'id', $idOpera);
    $autore  = FPersistentManager::load('EUtente', 'id', $utente->getId());

    if (!$opera instanceof EOpera || !$autore instanceof EUtente) {
        header('Location: /Gallerist/catalogo/esploraCatalogo');
        exit;
    }
    
if ($opera->getArtista()->getId() === $utente->getId()) {
    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera . '?errore=propria_opera');
    exit;
}

    $recensione = new ECommento(
        0,
        $commento,
        $valutazione,
        new DateTimeImmutable(),
        $autore,
        $opera
    );

    FPersistentManager::store($recensione);

    header('Location: /Gallerist/catalogo/visualizzaDettagliOpera/' . $idOpera . '?recensione=aggiunta');
    exit;
}
}
?>