<?php


class EStatoArchiviata extends EStatoSegnalazione {
    public function __construct() { $this->nomeStato = "Falsa segnalazione / Archiviata"; }
    public function getNomeStato(): string { return 'Archiviata'; }
}