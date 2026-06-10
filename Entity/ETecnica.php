<?php
/**
 * Classe che modella una Tecnica Artistica (es. Olio su tela, Acquerello).
 * @package Entity
 */
class ETecnica {
    private int $id;
    private string $nome;
    private string $descrizione;

    public function __construct(int $id, string $nome, string $descrizione = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->descrizione = $descrizione;
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }

    public function getDescrizione(): string { return $this->descrizione; }
    public function setDescrizione(string $descrizione): void { $this->descrizione = $descrizione; }
}
?>