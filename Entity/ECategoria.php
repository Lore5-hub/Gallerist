<?php

/*da ricontrollare*/

/**
 * Classe che modella la categoria di un'opera d'arte.
 * @package Entity
 */
class ECategoria {
    private string $nome;

    public function __construct(string $nome) {
        $this->nome = $nome;
    }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }
}
?>