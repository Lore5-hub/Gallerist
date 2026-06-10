<?php
/**
 * Classe astratta che modella lo stato di avanzamento di una segnalazione.
 * @package Entity
 */
abstract class EStatoSegnalazione {
    protected string $nomeStato;
    public function getNomeStato(): string { return $this->nomeStato; }
}