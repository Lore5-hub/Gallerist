<?php
require_once 'EUtente.php';
require_once 'EOpera.php';

//da ricontrollare il tipo di dato della data ordine    

/**
 * Classe che modella la transazione di acquisto diretto di un'opera.
 * @package Entity
 */
class EOrdine {
    private int $id;
    private string $dataOrdine;
    private string $metodoPagamento;
    private string $indirizzoSpedizione;
    private float $costoSpedizione;
    private float $totaleArticolo;
    private float $totaleOrdine;
    private float $commissionePiattaforma;
    
    // Associazioni come tipi di riferimento (Slide 4 del PPT 04)
    private EUtente $acquirente;
    private EOpera $opera;

    private function calcolaTotaleOrdine(): float {
    // Il totale base è il costo dell'opera più la spedizione
    $totale = $this->totaleArticolo + $this->costoSpedizione;
    return $totale;
}
    private function calcolaTrattenuta(): float {
        // Calcoliamo la percentuale solo sul costo dell'articolo (non sulla spedizione)
        return ($this->totaleArticolo * self::PERCENTUALE_COMMISSIONE) / 100;
    }

    public const PERCENTUALE_COMMISSIONE = 10.0;  //così da modificare facilmente le commissioni
    public function __construct(
        int $id, string $dataOrdine, string $metodoPagamento, string $indirizzoSpedizione,
        float $costoSpedizione, float $totaleArticolo,
        float $commissionePiattaforma, EUtente $acquirente, EOpera $opera
    ) {
        $this->id = $id;
        $this->dataOrdine = $dataOrdine;
        $this->metodoPagamento = $metodoPagamento;
        $this->indirizzoSpedizione = $indirizzoSpedizione;
        $this->costoSpedizione = $costoSpedizione;
        $this->totaleArticolo = $totaleArticolo;
        $this->commissionePiattaforma = $commissionePiattaforma;
        $this->acquirente = $acquirente;
        $this->opera = $opera;

        //Nel costruttore si richiedono solo i dati grezzi e si calcolano i totali e le commissioni in automatico, così da evitare errori di inserimento

        // Calcoliamo il totale in automatico!
        $this->totaleOrdine = $this->calcolaTotaleOrdine();

        // 2. Calcoliamo la trattenuta della galleria (in euro)
        $this->commissionePiattaforma = $this->calcolaTrattenuta();
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function getDataOrdine(): string { return $this->dataOrdine; }
    public function setDataOrdine(string $dataOrdine): void { $this->dataOrdine = $dataOrdine; }

    public function getMetodoPagamento(): string { return $this->metodoPagamento; }
    public function setMetodoPagamento(string $metodoPagamento): void { $this->metodoPagamento = $metodoPagamento; }

    public function getIndirizzoSpedizione(): string { return $this->indirizzoSpedizione; }
    public function setIndirizzoSpedizione(string $indirizzoSpedizione): void { $this->indirizzoSpedizione = $indirizzoSpedizione; }

    public function getCostoSpedizione(): float { return $this->costoSpedizione; }
    public function setCostoSpedizione(float $costoSpedizione): void { 
    $this->costoSpedizione = $costoSpedizione; 
    // Ricalcola il totale se cambia la spedizione
    $this->totaleOrdine = $this->calcolaTotaleOrdine();
}

    public function getTotaleArticolo(): float { return $this->totaleArticolo; }
    public function setTotaleArticolo(float $totaleArticolo): void { 
    $this->totaleArticolo = $totaleArticolo; 
    // Ricalcola il totale se cambia il costo dell'articolo
    $this->totaleOrdine = $this->calcolaTotaleOrdine();
}

    public function getTotaleOrdine(): float { return $this->totaleOrdine; }
    public function setTotaleOrdine(float $totaleOrdine): void { $this->totaleOrdine = $totaleOrdine; }

    public function getCommissionePiattaforma(): float { return $this->commissionePiattaforma; }
    public function setCommissionePiattaforma(float $commissionePiattaforma): void { $this->commissionePiattaforma = $commissionePiattaforma; }

    public function getAcquirente(): EUtente { return $this->acquirente; }
    public function setAcquirente(EUtente $acquirente): void { $this->acquirente = $acquirente; }

    public function getOpera(): EOpera { return $this->opera; }
    public function setOpera(EOpera $opera): void { $this->opera = $opera; }
}
?>