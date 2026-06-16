<?php
require_once 'EUtente.php';
require_once 'EOpera.php';

/**
 * Classe che modella la recensione/commento lasciata su un'opera.
 * @package Entity
 */
class ECommento {
    private int $id; // Identificativo univoco sul DB
    private string $testo;
    private int $valutazione; // Valutazione in stelle (es. da 1 a 5)
    private string $data;
    private EUtente $autore; // Associazione con l'entità Utente
    private EOpera $opera;   // Associazione con l'entità Opera

    public function __construct(int $id, string $testo, int $valutazione, string $data, EUtente $autore, EOpera $opera) {
        $this->id = $id;
        $this->testo = $testo;
        $this->setValutazione($valutazione); // Usiamo il setter per attivare il controllo 1-5
        $this->data = $data;
        $this->autore = $autore;
        $this->opera = $opera; //  Ora funziona correttamente!
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }

    public function getTesto(): string { return $this->testo; }
    public function setTesto(string $testo): void { $this->testo = $testo; }

    public function getValutazione(): int { return $this->valutazione; }
    public function setValutazione(int $valutazione): void {
        if ($valutazione < 1 || $valutazione > 5) {
            throw new \InvalidArgumentException("La valutazione deve essere compresa tra 1 e 5.");
        }
        $this->valutazione = $valutazione; 
    }

    public function getData(): string { return $this->data; }
    public function setData(string $data): void { $this->data = $data; }

    public function getAutore(): EUtente { return $this->autore; }
    public function setAutore(EUtente $autore): void { $this->autore = $autore; }

    public function getOpera(): EOpera { return $this->opera; }
    public function setOpera(EOpera $opera): void { $this->opera = $opera; }
}