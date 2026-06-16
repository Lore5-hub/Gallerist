<?php

/**
 * Classe principale che modella la valutazione (voto e commento) data da un utente a un'opera.
 */
class EValutazione {
    private int $id;
    private int $idUtente; // L'utente che esprime la valutazione
    private int $idOpera;  // L'opera che viene valutata
    private int $voto;     // Il voto effettivo (es. da 1 a 5)
    private string $commentoOpzionale;
    private string $dataValutazione;

    public function __construct(
        int $id, int $idUtente, int $idOpera, 
        int $voto, string $commentoOpzionale, string $dataValutazione
    ) {
        $this->id = $id;
        $this->idUtente = $idUtente;
        $this->idOpera = $idOpera;
        $this->setVoto($voto); // Usiamo il setter per attivare subito il controllo del range
        $this->commentoOpzionale = $commentoOpzionale;
        $this->dataValutazione = $dataValutazione;
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    
    public function getIdUtente(): int { return $this->idUtente; }
    public function setIdUtente(int $idUtente): void { $this->idUtente = $idUtente; }

    public function getIdOpera(): int { return $this->idOpera; }
    public function setIdOpera(int $idOpera): void { $this->idOpera = $idOpera; }

    public function getVoto(): int { return $this->voto; }
    public function setVoto(int $voto): void {
        // Controllo di sicurezza: il voto deve essere per forza compreso tra 1 e 5
        if ($voto < 1 || $voto > 5) {
            throw new \InvalidArgumentException("Il voto deve essere compreso tra 1 e 5.");
        }
        $this->voto = $voto;
    }

    public function getCommentoOpzionale(): string { return $this->commentoOpzionale; }
    public function setCommentoOpzionale(string $commentoOpzionale): void { $this->commentoOpzionale = $commentoOpzionale; }

    public function getDataValutazione(): string { return $this->dataValutazione; }
    public function setDataValutazione(string $dataValutazione): void { $this->dataValutazione = $dataValutazione; }
}