<?php
/**
 * Classe che modella l'Utente standard del sistema.
 * @package Entity
 */
class EUtente {
    
    private ?int $id = null; 
    private string $nome;
    private string $cognome;
    private DateTimeImmutable $dataDiNascita;  
    private string $indirizzo;
    private string $nickname;
    private string $telefono;
    private string $email;
    private string $password;
    private ?string $immagineProfilo; 
    private string $statoAccount; 
    private string $ruolo;
    private DateTimeImmutable $dataRegistrazione;
    // Costanti per lo Stato Account
    public const STATO_ATTIVO  = "attivo";
    public const STATO_BANNATO = "Bannato";

    // COSTANTI PER I RUOLI
    public const RUOLO_USER  = "Utente registrato";
    public const RUOLO_ADMIN = "Amministratore";
    public const RUOLO_ARTISTA = 'Artista';

    /**
     * Costruttore della classe.
     */
    public function __construct(
    int $id, string $nome, string $cognome, DateTimeImmutable $dataDiNascita,
    string $indirizzo, string $nickname, string $telefono, string $email,
    string $password, ?string $immagineProfilo, string $statoAccount = self::STATO_ATTIVO,
    string $ruolo = self::RUOLO_USER,
    ?DateTimeImmutable $dataRegistrazione = null  
)  {
        $this->id = $id;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->dataDiNascita = $dataDiNascita;
        $this->indirizzo = $indirizzo;
        $this->nickname = $nickname;
        $this->setTelefono($telefono); 
        $this->email = $email;
        $this->password = $password; 
        $this->immagineProfilo = $immagineProfilo;
        $this->statoAccount = $statoAccount;
        $this->setRuolo($ruolo); //  Utilizza il setter per validare il ruolo
         $this->dataRegistrazione = $dataRegistrazione ?? new DateTimeImmutable();
    }

    // --- GETTER & SETTER ---
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
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
    
    if ($telefono === '') {
        $this->telefono = '';
        return;
    }
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

    //  NUOVI GETTER & SETTER PER IL RUOLO
    public function getRuolo(): string { return $this->ruolo; }
    public function setRuolo(string $ruolo): void {
        $ruoliValidi = [self::RUOLO_USER, self::RUOLO_ARTISTA, self::RUOLO_ADMIN];
        if (!in_array($ruolo, $ruoliValidi)) {
            throw new \InvalidArgumentException("Ruolo non valido: $ruolo");
        }
        $this->ruolo = $ruolo;
    }
    public function isArtista(): bool {
    return $this->ruolo === self::RUOLO_ARTISTA;
}
public function getNazionalita(): string { return ''; }
public function getDataRegistrazione(): DateTimeImmutable { return $this->dataRegistrazione; }
public function setDataRegistrazione(DateTimeImmutable $data): void { $this->dataRegistrazione = $data; }
}
?>