<?php



/**
 * Classe principale per la gestione delle segnalazioni sui contenuti o utenti della piattaforma.
 */
class ESegnalazione {
    private int $id;
    private string $motivo;
    private string $notaOpzionale;
    private string $dataSegnalazione;
    private string $tipoTarget; // 'opera', 'utente', 'commento'
    private int $idTarget; // L'ID effettivo dell'oggetto segnalato
    private int $idSegnalatore; // L'utente che ha inviato la segnalazione
    private EStatoSegnalazione $stato; // Gestito tramite State Pattern come richiesto dal prof

    public function __construct(
        int $id, string $motivo, string $notaOpzionale, string $dataSegnalazione, 
        string $tipoTarget, int $idTarget, int $idSegnalatore
    ) {
        $this->id = $id;
        $this->motivo = $motivo;
        $this->notaOpzionale = $notaOpzionale;
        $this->dataSegnalazione = $dataSegnalazione;
        $this->tipoTarget = $tipoTarget;
        $this->idTarget = $idTarget;
        $this->idSegnalatore = $idSegnalatore;
        $this->stato = new EStatoNuova(); // All'inizio è sempre nello stato Nuova
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function getMotivo(): string { return $this->motivo; }
    public function getNotaOpzionale(): string { return $this->notaOpzionale; }
    public function getDataSegnalazione(): string { return $this->dataSegnalazione; }
    public function getTipoTarget(): string { return $this->tipoTarget; }
    public function getIdTarget(): int { return $this->idTarget; }
    public function getIdSegnalatore(): int { return $this->idSegnalatore; }
    
    public function getStato(): EStatoSegnalazione { return $this->stato; }
    public function setStato(EStatoSegnalazione $stato): void { $this->stato = $stato; }
}
?>