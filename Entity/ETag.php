<?php

/*da ricontrollare*/

/**
 * Classe che modella i tag associati alle opere.
 * @package Entity
 */
class ETag {
    private string $nomeTag;

    public function __construct(string $nomeTag) {
        $this->nomeTag = $nomeTag;
    }

    public function getNomeTag(): string { return $this->nomeTag; }
    public function setNomeTag(string $nomeTag): void { $this->nomeTag = $nomeTag; }
}
?>