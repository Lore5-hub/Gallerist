<?php
/**
 * Stato: Opera già acquistata da un collezionista.
 */
class EStatoVenduto extends EStatoOpera {
    public function __construct() { $this->nomeStato = "Venduta"; }
    public function isVendibile(): bool { return false; }
    // Un'opera venduta è storicizzata e non può essere modificata dall'artista
    public function puoEssereModificata(): bool { return false; } 
}
?>