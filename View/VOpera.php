<?php

/**
 * Class VOpera si occupa dell'input-output per le funzionalità del Portfolio e delle Recensioni (UC4, UC5)
 * @package View
 */
class VOpera
{
	/** @var Smarty */
	private $smarty;

	/**
	 * Funzione che inizializza e configura smarty.
	 */
	public function __construct() {
		$this->smarty = StartSmarty::configuration();
	}

	/**
	 * UC5: Gestione Portfolio Artistico
	 * Mostra la pagina con tutte le opere caricate da uno specifico artista.
	 * @param EUtente $artista L'artista proprietario del portfolio
	 * @param array $opere Elenco di oggetti EOpera dell'artista
	 */
	public function mostraPortfolio($artista, $opere) {
		// Supponiamo che il controller abbia già verificato che l'utente è loggato come artista
		$this->smarty->assign('userlogged', "loggato");
		$this->smarty->assign('ruolo', "Artista");
		
		$this->smarty->assign('nomeArtista', $artista->getNome());
		$this->smarty->assign('cognomeArtista', $artista->getCognome());
		
		// Estraiamo le immagini di copertina in Base64 per ogni opera usando un helper interno
		$immaginiOpere = array();
		foreach ($opere as $opera) {
		    // Immagina che l'opera abbia un metodo getCopertina()
			list($type, $pic64) = $this->codificaImmagine($opera->getCopertina(), 'opera');
			$immaginiOpere[$opera->getId()] = array('type' => $type, 'pic64' => $pic64);
		}
		
		$this->smarty->assign('opere', $opere);
		$this->smarty->assign('immaginiOpere', $immaginiOpere);
		
		$this->smarty->display('portfolio_artista.tpl');
	}

	/**
	 * UC5: Form di Inserimento Opera
	 * Mostra il modulo per caricare una nuova opera. Prevede la gestione degli errori.
	 * * @param string|null $errore Eventuale stringa di errore (es. "dimensione_eccessiva", "formato_errato")
	 */
	public function mostraFormInserimento($errore = null) {
		$this->smarty->assign('userlogged', "loggato");
		
		if ($errore != null) {
			switch ($errore) {
				case "formato_immagine":
					$this->smarty->assign('erroreImmagine', "errore");
					break;
				case "dati_mancanti":
					$this->smarty->assign('erroreDati', "errore");
					break;
			}
		}
		$this->smarty->display('inserisci_opera.tpl');
	}

	/**
	 * UC4: Gestione Interazioni (Recensioni)
	 * Mostra la pagina di dettaglio di un'opera e la lista dei commenti/recensioni associati.
	 * * @param EOpera $opera L'opera da visualizzare
	 * @param array $recensioni Elenco di oggetti ERecensione associati all'opera
	 * @param string|null $erroreRecensione Eventuale errore durante l'inserimento della recensione
	 */
	public function mostraDettaglioOpera($opera, $recensioni, $erroreRecensione = null) {
		// Controllo se l'utente che sta guardando è loggato (serve per fargli vedere il form della recensione)
		if (CUtente::isLogged()) {
			$this->smarty->assign('userlogged', "loggato");
		}

		// Assegno i dati dell'opera
		$this->smarty->assign('opera', $opera);
		$this->smarty->assign('artista', $opera->getArtista());
		
		// Assegno le recensioni
		$this->smarty->assign('recensioni', $recensioni);
		
		// Gestione dell'errore (es. ha cercato di recensire senza mettere il voto)
		if ($erroreRecensione != null) {
			$this->smarty->assign('erroreRecensione', "errore");
		}
		
		$this->smarty->display('dettaglio_opera.tpl');
	}

	/**
	 * Funzione helper per codificare le immagini in Base64 (ispirata al file VUtente.php)
	 * @param mixed $image Oggetto immagine
	 * @param string $tipo Tipo di default (es. 'opera')
	 * @return array
	 */
	private function codificaImmagine($image, $tipo) {
		if (isset($image) && $image != null) {
			$pic64 = base64_encode($image->getData());
			$type = $image->getType();
		} else {
			// Se non c'è l'immagine, carica un'immagine di default (es. tela bianca)
			$data = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/Gallerist/Smarty/immagini/default_opera.png');
			$pic64 = base64_encode($data);
			$type = "image/png";
		}
		return array($type, $pic64);
	}
}
?>