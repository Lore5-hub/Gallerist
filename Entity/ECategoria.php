<?php



/**
 * Classe che modella la categoria di un'opera d'arte.
 * @package Entity
 */
class ECategoria {
    private string $nome;
    private string $descrizione; // Descrizione opzionale della categoria
   
    public function __construct(string $nome, string $descrizione = '') {
        $this->nome = $nome;
        $this->descrizione = $descrizione;
    }

    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }

    public function getDescrizione(): string { return $this->descrizione; }
    public function setDescrizione(string $descrizione): void { $this->descrizione = $descrizione; }
    
}
?>