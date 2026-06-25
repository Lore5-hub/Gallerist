<?php
// Entity/ETag.php

/**
 * Modella un tag associato a un'opera d'arte.
 *
 * La relazione opera-tag è many-to-many e vive sulla tabella di join `opera_tag`
 * (idOpera, idTag). FTag gestisce questa relazione tramite una query JOIN.
 *
 * $id è necessario per le operazioni Foundation (update, delete per PK sulla
 * tabella `tag`). Il campo $nomeTag corrisponde alla colonna `nome` sul DB.
 *
 * @package Entity
 */
class ETag {

    private int    $id;
    private string $nomeTag;

    /**
     * @param int    $id      0 per nuovi inserimenti (AUTO_INCREMENT)
     * @param string $nomeTag Nome del tag (es. "paesaggio", "astratto")
     */
    public function __construct(int $id, string $nomeTag) {
        $this->id      = $id;
        $this->nomeTag = $nomeTag;
    }

    public function getId(): int             { return $this->id; }
    public function setId(int $id): void     { $this->id = $id; }

    public function getNomeTag(): string              { return $this->nomeTag; }
    public function setNomeTag(string $nomeTag): void { $this->nomeTag = $nomeTag; }
}
?>