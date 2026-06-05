<?php
require_once 'EArtista.php';
require_once 'ECategoria.php';
require_once 'EImmagine.php';
require_once 'ETag.php';
require_once 'ECommento.php';

/**
 * Classe centrale che modella l'Opera d'Arte e ne aggrega i componenti correlati.
 * @package Entity
 */
class EOpera {
    private int $id;
    private string $titolo;
    private int $anno;
    private string $tecnica;
    private string $dimensioni;
    private string $descrizione;
    private float $prezzo;
    private float $valutazioneMedia;
    private string $statoOpera; // Es. "In vendita", "Venduta", "Riservata"

    // Associazioni dirette ed aggregazioni di tipo strutturato (Slide 13 del PPT 10)
    private EArtista $artista;
    private ECategoria $categoria;
    private array $immagini = []; // Contiene oggetti di tipo EImmagine
    private array $tag = [];      // Contiene oggetti di tipo ETag
    private array $commenti = []; // Contiene oggetti di tipo ECommento
    
    public const IN_VENDITA = "In vendita";
    public const VENDUTA = "Venduta";
    public const NON_IN_VENDITA= "Non in vendita";

    public function __construct(
        int $id, string $titolo, int $anno, string $tecnica, string $dimensioni,
        string $descrizione, float $prezzo, float $valutazioneMedia,string $statoOpera = self::NON_IN_VENDITA,
        EArtista $artista, ECategoria $categoria
    ) {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->anno = $anno;
        $this->tecnica = $tecnica;
        $this->dimensioni = $dimensioni;
        $this->descrizione = $descrizione;
        $this->prezzo = $prezzo;
        $this->valutazioneMedia = $valutazioneMedia;
        $this->artista = $artista;
        $this->categoria = $categoria;
        $this->statoOpera = $statoOpera;
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function getTitolo(): string { return $this->titolo; }
    public function getAnno(): int { return $this->anno; }
    public function getTecnica(): string { return $this->tecnica; }
    public function getDimensioni(): string { return $this->dimensioni; }
    public function getDescrizione(): string { return $this->descrizione; }
    public function getPrezzo(): float { return $this->prezzo; }
    public function getValutazioneMedia(): float { return $this->valutazioneMedia; }
    public function getArtista(): EArtista { return $this->artista; }
    public function getCategoria(): ECategoria { return $this->categoria; }
    public function getStatoOpera(): string { return $this->statoOpera; }
    public function setStatoOpera(string $statoOpera): void {
    // Creiamo un array con tutti gli stati logicamente ammessi nel sistema
    $statiValidi = [self::IN_VENDITA, self::VENDUTA, self::NON_IN_VENDITA];
    
    // Verifichiamo se il valore passato è tra quelli consentiti
    if (!in_array($statoOpera, $statiValidi)) {
        throw new \InvalidArgumentException("Stato opera non valido: $statoOpera");
    }
    
    $this->statoOpera = $statoOpera;
}

    // Gestione degli oggetti aggregati (Metodi per popolare le liste)
    public function getImmagini(): array { return $this->immagini; }
    public function addImmagine(EImmagine $immagine): void { $this->immagini[] = $immagine; }

    public function getTag(): array { return $this->tag; }
    public function addTag(ETag $tag): void { $this->tag[] = $tag; }

    public function getCommenti(): array { return $this->commenti; }
    public function addCommento(ECommento $commento): void { $this->commenti[] = $commento; }
}
?>