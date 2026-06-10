<?php
require_once 'EUtente.php';

/*da ricontrollare per il formato di data*/

/**
 * Classe che modella la recensione/commento lasciata su un'opera.
 * @package Entity
 */
class ECommento {
    private string $testo;
    private int $valutazione; // Valutazione in stelle (es. da 1 a 5)
    private string $data;
    private EUtente $autore; // Associazione "rilascia" con l'entità Utente

    public function __construct(string $testo, int $valutazione, string $data, EUtente $autore) {
        $this->testo = $testo;
        $this->valutazione = $valutazione;
        $this->data = $data;
        $this->autore = $autore;
    }

    public function getTesto(): string { return $this->testo; }
    public function setTesto(string $testo): void { $this->testo = $testo; }

    public function getValutazione(): int { return $this->valutazione; }
    public function setValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new \InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");}
         $this->valutazione = $valutazione; }

    public function getData(): string { return $this->data; }
    public function setData(string $data): void { $this->data = $data; }

    public function getAutore(): EUtente { return $this->autore; }
    public function setAutore(EUtente $autore): void { $this->autore = $autore; }
}
?>