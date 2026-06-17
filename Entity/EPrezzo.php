<?php

/**
 * Classe che modella un Prezzo (Value Object).
 * Non ha un ID, è identificata solo dal suo valore e dalla sua valuta.
 * @package Entity
 */
class EPrezzo {

    private float $valore;
    private string $valuta; // es. "EUR", "USD", "GBP"

    public function __construct(float $valore, string $valuta = "EUR") {
        $this->valore = $valore;
        $this->valuta = $valuta;
    }

    // --- GETTER & SETTER ---
    public function getValore(): float { return $this->valore; }
    public function setValore(float $valore): void { $this->valore = $valore; }

    public function getValuta(): string { return $this->valuta; }
    public function setValuta(string $valuta): void { $this->valuta = $valuta; }

    /**
     * Metodo di utilità per stampare il prezzo formattato nella View
     */
    public function getPrezzoFormattato(): string {
        return number_format($this->valore, 2) . " " . $this->valuta;
    }
}
?>