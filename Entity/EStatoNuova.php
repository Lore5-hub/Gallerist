<?php
class EStatoNuova extends EStatoSegnalazione {
    public function __construct() { $this->nomeStato = "In attesa di revisione"; }
    public function getNomeStato(): string { return 'Aperta'; }
}