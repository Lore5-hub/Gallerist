<?php

// Classe di controllo per raccogliere i dati e generare le statistiche per l'amministratore
class CStatistichePiattaforma {
    
    // Attributi per salvare il filtro delle date
    private $dataInizio = null;
    private $dataFine = null;

    // Inizializza la dashboard caricando le configurazioni base
    public function inizializzaDashboardStatistiche() {
        // Imposta le date di default per gli ultimi 30 giorni
        $this->dataInizio = date('Y-m-d', strtotime('-30 days'));
        $this->dataFine = date('Y-m-d');
    }

    // Imposta il periodo di tempo per filtrare i dati
    public function impostaPeriodoTempo($dataInizio, $dataFine) {
        $this->dataInizio = $dataInizio;
        $this->dataFine = $dataFine;
    }

    // Prende i dati dal database (Foundation) e fa i calcoli (medie dei voti e ordini)
    public function recuperaEAggregaStatistiche() {
        $fOrdine = new FOrdine();
        $fValutazione = new FValutazione();

        // Recuperiamo gli ordini e le valutazioni nel periodo scelto
        $ordini = $fOrdine->recuperaOrdiniPerPeriodo($this->dataInizio, $this->dataFine);
        $valutazioni = $fValutazione->recuperaTutteLeValutazioni();

        $totaleOrdini = count($ordini);
        
        // Ciclo per calcolare la media delle valutazioni (come spiegato nella trascrizione del prof)
        $sommaVoti = 0;
        $conteggioVoti = 0;
        
        foreach ($valutazioni as $valutazione) {
            $sommaVoti += $valutazione->getVoto(); 
            $conteggioVoti++;
        }
        
        $valutazioneMedia = $conteggioVoti > 0 ? ($sommaVoti / $conteggioVoti) : 0.0;

        // Prepariamo l'array con i dati aggregati
        $datiAggregati = [
            'totaleOrdini' => $totaleOrdini,
            'valutazioneMediaGenerale' => $valutazioneMedia,
            'nuoviUtenti' => 0 // Valore iniziale da aggiornare con la logica reale
        ];

        return $datiAggregati;
    }

    // Trasforma i dati in strutture pronte per essere mostrate nei grafici della View
    public function generaGraficiVisivi() {
        $dati = $this->recuperaEAggregaStatistiche();
        
        // Struttura dati pronta per essere passata ai grafici (es. Chart.js)
        $datiGrafico = [
            'labels' => ['Ordini Totali', 'Valutazione Media'],
            'datasets' => [
                'valori' => [$dati['totaleOrdini'], $dati['valutazioneMediaGenerale']]
            ]
        ];

        return $datiGrafico;
    }

    // --- GETTER & SETTER ---
    public function getDataInizio() { return $this->dataInizio; }
    public function setDataInizio($dataInizio) { $this->dataInizio = $dataInizio; }

    public function getDataFine() { return $this->dataFine; }
    public function setDataFine($dataFine) { $this->dataFine = $dataFine; }
}