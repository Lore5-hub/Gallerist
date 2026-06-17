<?php
require_once 'EUtente.php';
require_once 'EOpera.php';



/**
 * Classe che modella la recensione/commento lasciata su un'opera.
 * @package Entity
 */
class ECommento {
    private int $id;
    private string $testo;
    private int $valutazione; // Valutazione in stelle (es. da 1 a 5)
    
    private DateTimeImmutable $data;
   
    private EUtente $autore; // Associazione "rilascia" con l'entità Utente
    private EOpera $opera;

    public function __construct(int $id, string $testo, int $valutazione, DateTimeImmutable $data, EUtente $autore, EOpera $opera) {
        $this->id = $id;
        $this->testo = $testo;
        $this->valutazione = $valutazione;
        $this->data = $data;
        $this->autore = $autore;
        $this->opera = $opera;
    }

    public function getId(): int { return $this->id; }
    public function getTesto(): string { return $this->testo; }
    public function setTesto(string $testo): void { $this->testo = $testo; }

    public function getValutazione(): int { return $this->valutazione; }
    public function setValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new \InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");}
         $this->valutazione = $valutazione; }

    public function getData(): DateTimeImmutable { return $this->data; }
    public function setData(DateTimeImmutable $data): void { $this->data = $data; }

    public function getAutore(): EUtente { return $this->autore; }
    public function setAutore(EUtente $autore): void { $this->autore = $autore; }

    public function getOpera(): EOpera { return $this->opera; }
    public function setOpera(EOpera $opera): void { $this->opera = $opera; }
}
?>