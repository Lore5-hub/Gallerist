<?php
/**
 * Stato: Opera attivamente sul mercato.
 */
class EStatoInVendita extends EStatoOpera {
    public function __construct() { $this->nomeStato = "In Vendita"; }
    public function isVendibile(): bool { return true; }
    public function puoEssereModificata(): bool { return true; }
}