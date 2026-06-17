<?php
require_once 'EUtente.php';

/**
 * La classe EProvvedimento rappresenta l'entità di un provvedimento restrittivo (Ban)
 * applicato a un utente della piattaforma su indicazione dell'Amministratore.
 * @package Entity
 */
class EProvvedimento {
    
    private int $id;
    private string $tipoBan;      // Es. "Temporaneo", "Permanente"
    private string $dataInizio;   // Formato 'Y-m-d'
    private string $dataFine;     // Formato 'Y-m-d'
    private string $motivo;

    // Associazione diretta verso l'utente sanzionato (Slide 13 del PPT 10)
    private EUtente $utenteSanzionato;

    /**
     * Costruttore dell'oggetto EProvvedimento.
     * Prevede la tipizzazione forte dei parametri e l'inizializzazione dello stato temporale.
     */
    public function __construct(
        int $id, string $tipoBan, string $dataInizio = null, 
        string $dataFine, string $motivo, EUtente $utenteSanzionato
    ) {
        $this->id = $id;
        $this->tipoBan = $tipoBan;
        // Se la data di inizio non viene passata, viene impostata automaticamente su quella odierna
        $this->dataInizio = $dataInizio ?? date('Y-m-d');
        $this->dataFine = $dataFine;
        $this->motivo = $motivo;
        $this->utenteSanzionato = $utenteSanzionato;
    }

    /**
     * Verifica dinamicamente se il provvedimento è attualmente in corso di validità
     * confrontando la data corrente con i limiti temporali della sanzione.
     * @return bool True se il ban è attivo, False altrimenti
     */
    public function isAttivo(): bool {
        $oggi = date('Y-m-d');
        if ($this->tipoBan === "Permanente") {
            return $oggi >= $this->dataInizio;
        }
        return ($oggi >= $this->dataInizio && $oggi <= $this->dataFine);
    }

    // --- GETTER & SETTER ---

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getTipoBan(): string { return $this->tipoBan; }
    public function setTipoBan(string $tipoBan): void { $this->tipoBan = $tipoBan; }

    public function getDataInizio(): string { return $this->dataInizio; }
    public function setDataInizio(string $dataInizio): void { $this->dataInizio = $dataInizio; }

    public function getDataFine(): string { return $this->dataFine; }
    public function setDataFine(string $dataFine): void { $this->dataFine = $dataFine; }

    public function getMotivo(): string { return $this->motivo; }
    public function setMotivo(string $motivo): void { $this->motivo = $motivo; }

    public function getUtenteSanzionato(): EUtente { return $this->utenteSanzionato; }
    public function setUtenteSanzionato(EUtente $utenteSanzionato): void { $this->utenteSanzionato = $utenteSanzionato; }
}