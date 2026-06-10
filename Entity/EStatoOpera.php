<?php
/**
 * Classe astratta che definisce lo Stato concettuale di un'opera d'arte.
 * @package Entity
 */
abstract class EStatoOpera {
    protected string $nomeStato;

    public function getNomeStato(): string { return $this->nomeStato; }
    
    // Metodi polimorfici che cambiano comportamento a seconda dello stato
    abstract public function isVendibile(): bool;
    abstract public function puoEssereModificata(): bool;
}

