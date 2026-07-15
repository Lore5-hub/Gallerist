<?php
require_once 'EUtente.php'; /*include il contenuto di un altro file nel file corrente, come se il codice fosse scritto direttamente lì. */

/**
 * Classe che modella l'Artista, specializzazione di Utente.
 * @package Entity
 */
class EArtista extends EUtente {
    
    private string $biografia;
    private string $stileArtistico;
    private string $cartaIdentita; // Es. URL o nome file del documento
    private string $statoValidazione;
    private string $nazionalita = '';
    private float  $valutazioneMedia = 0.0;
     public const STATO_IN_ATTESA = "IN_ATTESA";  /* attivo e bannato sono in utente */
private string $portfolio = '';
    

    /**
     * Costruttore della classe. Chiama il costruttore della superclasse, per inizializzare gli attributi ereditati.
     */
    public function __construct(
        int $id, string $nome, string $cognome, DateTimeImmutable $dataDiNascita, 
        string $indirizzo, string $nickname, string $telefono, string $email, 
        string $password, ?string $immagineProfilo,
        string $biografia, string $stileArtistico, string $cartaIdentita, string $statoValidazione = self::STATO_IN_ATTESA, string $nazionalita = ''
    ) {
        parent::__construct($id, $nome, $cognome, $dataDiNascita, $indirizzo, $nickname, $telefono, $email, $password, $immagineProfilo,  EUtente::STATO_ATTIVO, EUtente::RUOLO_ARTISTA);
        $this->biografia = $biografia;
        $this->stileArtistico = $stileArtistico;
        $this->cartaIdentita = $cartaIdentita;
        $this->statoValidazione = $statoValidazione; 
        $this->nazionalita      = $nazionalita;// Come da Use Case 1b
    }

   
    // --- GETTER & SETTER ---
    public function getBiografia(): string { return $this->biografia; }
    public function setBiografia(string $biografia): void { $this->biografia = $biografia; }

    public function getStileArtistico(): string { return $this->stileArtistico; }
    public function setStileArtistico(string $stileArtistico): void { $this->stileArtistico = $stileArtistico; }

    public function getCartaIdentita(): string { return $this->cartaIdentita; }
    public function setCartaIdentita(string $cartaIdentita): void { $this->cartaIdentita = $cartaIdentita; }

    public function getStatoValidazione(): string { return $this->statoValidazione; }
    public function setStatoValidazione(string $stato): void {
        $statiValidi = [self::STATO_IN_ATTESA, parent::STATO_ATTIVO, parent::STATO_BANNATO];
        if (!in_array($stato, $statiValidi)) {
            throw new \InvalidArgumentException("Stato non valido: $stato");
        }
    $this->statoValidazione = $stato;
    }
    public function getNazionalita(): string { return $this->nazionalita; }
public function setNazionalita(string $nazionalita): void { $this->nazionalita = $nazionalita; }

public function getValutazioneMedia(): float { return $this->valutazioneMedia; }
public function setValutazioneMedia(float $media): void { $this->valutazioneMedia = $media; }
    public function getPortfolio(): string { return $this->portfolio; }
public function setPortfolio(string $portfolio): void { $this->portfolio = $portfolio; }
}   