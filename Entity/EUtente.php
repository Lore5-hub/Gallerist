<?php
/**
 * Classe che modella l'Utente standard del sistema.
 * @package Entity
 */
class EUtente {
    // Attributi dedotti dal diagramma ER
    private ?int $id = null; // ID univoco dell'utente, generato dal DB
    private string $nome;
    private string $cognome;
    private DateTimeImmutable $dataDiNascita;  /*da modificare il tipo di dato creando la classe per la data in una cartella tipo utility/ */
    private string $indirizzo;
    private string $nickname;
    private string $telefono;
    private string $email;
    private string $password;
    private ?string $immagineProfilo; /*nullable così il foundation layer può distinguere facilmente "nessuna immagine impostata" da "path vuoto". */
    private string $statoAccount; // Es. "Attivo" o "Bannato"
    
    public const STATO_ATTIVO  = "Attivo";
    public const STATO_BANNATO = "Bannato";

    /**
     * Costruttore della classe.
     */
    public function __construct(
        int $id, string $nome, string $cognome, DateTimeImmutable $dataDiNascita, 
        string $indirizzo, string $nickname, string $telefono, string $email, 
        string $password, ?string $immagineProfilo = null, string $statoAccount = self::STATO_ATTIVO
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->dataDiNascita = $dataDiNascita;
        $this->indirizzo = $indirizzo;
        $this->nickname = $nickname;
        $this->setTelefono($telefono); // Utilizza il setter per validare il formato del telefono
        $this->email = $email;
        $this->password = $password; // Nota: In un sistema reale andrebbe hashata, ma nel dominio concettuale è una stringa.
        $this->immagineProfilo = $immagineProfilo;
        $this->statoAccount = $statoAccount;
    }



    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function getNome(): string { return $this->nome; }
    public function setNome(string $nome): void { $this->nome = $nome; }

    public function getCognome(): string { return $this->cognome; }
    public function setCognome(string $cognome): void { $this->cognome = $cognome; }

    public function getDataDiNascita(): DateTimeImmutable { return $this->dataDiNascita; }
    public function setDataDiNascita(DateTimeImmutable $dataDiNascita): void { $this->dataDiNascita = $dataDiNascita; }

    public function getIndirizzo(): string { return $this->indirizzo; }
    public function setIndirizzo(string $indirizzo): void { $this->indirizzo = $indirizzo; }

    public function getNickname(): string { return $this->nickname; }
    public function setNickname(string $nickname): void { $this->nickname = $nickname; }

    public function getTelefono(): string { return $this->telefono; }
    public function setTelefono(string $telefono): void {
        if (!preg_match('/^\+\d{1,3} \d{9,10}$/', $telefono)) {
            throw new \InvalidArgumentException("Numero di telefono non valido. Formato atteso: +39 3471234567");
        }
        $this->telefono = $telefono;
}

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getImmagineProfilo(): ?string { return $this->immagineProfilo; }
    public function setImmagineProfilo(?string $immagineProfilo): void { $this->immagineProfilo = $immagineProfilo; }

    public function getStatoAccount(): string { return $this->statoAccount; }
    public function setStatoAccount(string $stato): void {
        $statiValidi = [self::STATO_ATTIVO, self::STATO_BANNATO];
        if (!in_array($stato, $statiValidi)) {
            throw new \InvalidArgumentException("Stato non valido: $stato");
        }
        $this->statoAccount = $stato;
    }
}
?>