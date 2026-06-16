<?php

/**
 * Class VStatistiche si occupa dell'input-output per le funzionalità di analisi vendite (UC6)
 * @package View
 */
class VStatistiche
{
	/** @var Smarty */
	private $smarty;

	public function __construct() {
		$this->smarty = StartSmarty::configuration();
	}

	/**
	 * UC6: Consultazione Storico Vendite
	 * Mostra la dashboard con l'elenco degli ordini e i dati aggregati (guadagni).
	 * @param array $ordini Array di oggetti EOrdine
	 * @param array $datiStatistici Array con 'opere_vendute' e 'ricavo_totale'
	 * @param string|null $dataInizio Data inserita nel calendario (formato Y-m-d)
	 * @param string|null $dataFine Data inserita nel calendario (formato Y-m-d)
	 */
	public function mostraStoricoVendite($ordini, $datiStatistici, $dataInizio = null, $dataFine = null) {
		$this->smarty->assign('userlogged', "loggato");
		$this->smarty->assign('ruolo', "Artista");

		// Assegna la lista degli ordini alla tabella Smarty
		$this->smarty->assign('ordini', $ordini);
		
		// Assegna le statistiche calcolate dal DB per fare i grafici o i box di riepilogo
		$this->smarty->assign('totaleVendite', $datiStatistici['opere_vendute']);
		$this->smarty->assign('ricavoTotale', $datiStatistici['ricavo_totale']);
		
		// Se l'artista ha usato il calendario, rimandiamo le date alla view 
		// così i campi input type="date" rimangono compilati!
		if ($dataInizio != null && $dataFine != null) {
			$this->smarty->assign('filtroDataInizio', $dataInizio);
			$this->smarty->assign('filtroDataFine', $dataFine);
		}

		$this->smarty->display('storico_vendite.tpl');
	}
	
	/**
	 * UC6: Nel caso la ricerca per data dia errore (es. data fine antecedente a data inizio)
	 */
	public function mostraErroreFiltroDate() {
	    // Ricarichiamo la pagina base ma accendiamo il flag di errore
	    $this->smarty->assign('erroreDate', "errore");
	    $this->smarty->display('storico_vendite.tpl');
	}
}
?>