<?php
require_once 'EUtente.php';
require_once 'EOpera.php';
require_once 'EPrezzo.php'; /* Include la classe associata per il prezzo */
//da ricontrollare il tipo di dato della data ordine    

/**
 * Classe che modella la transazione di acquisto diretto di un'opera.
 * @package Entity
 */
class EOrdine {
    private int $id;
    private DateTimeImmutable $dataOrdine;
    private string $metodoPagamento;
    private string $indirizzoSpedizione;
    private EPrezzo $costoSpedizione;
    private EPrezzo $totaleArticolo;
    private EPrezzo $totaleOrdine;
    private EPrezzo $commissionePiattaforma;
    private string $tipo;
    // Associazioni come tipi di riferimento (Slide 4 del PPT 04)
    private EUtente $acquirente;
    private EOpera $opera;

    private function calcolaTotaleOrdine(): EPrezzo {
    // Il totale base è il costo dell'opera più la spedizione
    $totale = $this->totaleArticolo->getValore() + $this->costoSpedizione->getValore();
    return new EPrezzo($totale);
}
    private function calcolaTrattenuta(): EPrezzo {
        // Calcoliamo la percentuale solo sul costo dell'articolo (non sulla spedizione)
        $trattenuta = ($this->totaleArticolo->getValore() * self::PERCENTUALE_COMMISSIONE) / 100;
        return new EPrezzo($trattenuta);
    }

    public const PERCENTUALE_COMMISSIONE = 10.0;  //così da modificare facilmente le commissioni
    public function __construct(
    int $id, DateTimeImmutable $dataOrdine, string $metodoPagamento, string $indirizzoSpedizione,
    EPrezzo $costoSpedizione, EPrezzo $totaleArticolo,
    EPrezzo $commissionePiattaforma, EUtente $acquirente, EOpera $opera,
    string $tipo = 'diretto'  // ← aggiunto
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
    $this->tipo = $tipo;  // ← aggiunto

    $this->totaleOrdine = $this->calcolaTotaleOrdine();
    $this->commissionePiattaforma = $this->calcolaTrattenuta();
}

public function getTipo(): string { return $this->tipo; }
public function setTipo(string $tipo): void { $this->tipo = $tipo; }

    // --- GETTER & SETTER ---
    public function setId(int $id): void { $this->id = $id; }
    public function getId(): int { return $this->id; }
    public function getDataOrdine(): DateTimeImmutable { return $this->dataOrdine; }
    public function setDataOrdine(DateTimeImmutable $dataOrdine): void { $this->dataOrdine = $dataOrdine; }

    public function getMetodoPagamento(): string { return $this->metodoPagamento; }
    public function setMetodoPagamento(string $metodoPagamento): void { $this->metodoPagamento = $metodoPagamento; }

    public function getIndirizzoSpedizione(): string { return $this->indirizzoSpedizione; }
    public function setIndirizzoSpedizione(string $indirizzoSpedizione): void { $this->indirizzoSpedizione = $indirizzoSpedizione; }

    public function getCostoSpedizione(): EPrezzo { return $this->costoSpedizione; }
    public function setCostoSpedizione(EPrezzo $costoSpedizione): void { 
    $this->costoSpedizione = $costoSpedizione; 
    // Ricalcola il totale se cambia la spedizione
    $this->totaleOrdine = $this->calcolaTotaleOrdine();
}

    public function getTotaleArticolo(): EPrezzo { return $this->totaleArticolo; }
    public function setTotaleArticolo(EPrezzo $totaleArticolo): void { 
    $this->totaleArticolo = $totaleArticolo; 
    // Ricalcola il totale se cambia il costo dell'articolo
    $this->totaleOrdine = $this->calcolaTotaleOrdine();
}

    public function getTotaleOrdine(): EPrezzo { return $this->totaleOrdine; }
    public function setTotaleOrdine(EPrezzo $totaleOrdine): void { $this->totaleOrdine = $totaleOrdine; }

    public function getCommissionePiattaforma(): EPrezzo { return $this->commissionePiattaforma; }
    public function setCommissionePiattaforma(EPrezzo $commissionePiattaforma): void { $this->commissionePiattaforma = $commissionePiattaforma; }

    public function getAcquirente(): EUtente { return $this->acquirente; }
    public function setAcquirente(EUtente $acquirente): void { $this->acquirente = $acquirente; }

    public function getOpera(): EOpera { return $this->opera; }
    public function setOpera(EOpera $opera): void { $this->opera = $opera; }
}
?>