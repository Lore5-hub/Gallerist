<?php
require_once 'EArtista.php';
require_once 'ECategoria.php';
require_once 'EImmagine.php';
require_once 'ETag.php';
require_once 'ECommento.php';
require_once 'ETecnica.php'; /* Include la classe associata per la tecnica */
require_once 'EStatoOpera.php'; /* Include la gestione dello State Pattern dell'opera */

/**
 * Classe centrale che modella l'Opera d'Arte e ne aggrega i componenti correlati.
 * @package Entity
 */
class EOpera {
    private int $id;
    private string $titolo;
    private int $anno;
    private ETecnica $tecnica;
    private string $dimensioni;
    private string $descrizione;
    private float $prezzo;
    private EStatoOpera $statoOpera; // Es. "In vendita", "Venduta", "Riservata"

    // Associazioni dirette ed aggregazioni di tipo strutturato (Slide 13 del PPT 10)
    private EArtista $artista;
    private ECategoria $categoria;
    private array $immagini = []; // Contiene oggetti di tipo EImmagine
    private array $tag = [];      // Contiene oggetti di tipo ETag
    private array $commenti = []; // Contiene oggetti di tipo ECommento
    
    public function __construct(
        int $id, string $titolo, int $anno, ETecnica $tecnica, string $dimensioni,
        string $descrizione, float $prezzo, EStatoOpera $statoOpera = null,
        EArtista $artista, ECategoria $categoria
    ) {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->anno = $anno;
        $this->tecnica = $tecnica;
        $this->dimensioni = $dimensioni;
        $this->descrizione = $descrizione;
        $this->prezzo = $prezzo;
        $this->artista = $artista;
        $this->categoria = $categoria;
        // Di default l'opera nasce come semplicemente inserita (esposta)
        $this->statoOpera = $statoOpera ?? new EStatoInserito();
    }
    /**
     * Calcola dinamicamente la valutazione media ciclando sulle recensioni associate.
     * Sostituisce l'attributo statico rimosso su indicazione del professore.
     */
    public function getValutazioneMedia(): float {
        if (empty($this->commenti)) {
            return 0.0; // Nessun commento presente
        }
        $somma = 0;
        foreach ($this->commenti as $commento) {
            $somma += $commento->getValutazione();
        }
        return round($somma / count($this->commenti), 2);
    }

    // --- GETTER & SETTER ---
    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }
    public function getTitolo(): string { return $this->titolo; }
    public function setTitolo(string $titolo): void { $this->titolo = $titolo; }
    public function getAnno(): int { return $this->anno; }
    public function setAnno(int $anno): void { $this->anno = $anno; }
    public function getTecnica(): ETecnica { return $this->tecnica; }
    public function setTecnica(ETecnica $tecnica): void { $this->tecnica = $tecnica; }
    public function getDimensioni(): string { return $this->dimensioni; }
    public function setDimensioni(string $dimensioni): void { $this->dimensioni = $dimensioni; }
    public function getDescrizione(): string { return $this->descrizione; }
    public function setDescrizione(string $descrizione): void { $this->descrizione = $descrizione; }
    public function getPrezzo(): float { return $this->prezzo; }
    public function setPrezzo(float $prezzo): void { $this->prezzo = $prezzo; }
    public function getArtista(): EArtista { return $this->artista; }
    public function setArtista(EArtista $artista): void { $this->artista = $artista; }
    public function getStatoOpera(): EStatoOpera { return $this->statoOpera; }
    public function setStatoOpera(EStatoOpera $statoOpera): void {
    $this->statoOpera = $statoOpera;
}
    public function getCategoria(): ECategoria { return $this->categoria; }
    public function setCategoria(ECategoria $categoria): void { $this->categoria = $categoria; }
    // Gestione degli oggetti aggregati (Metodi per popolare le liste)
    public function getImmagini(): array { return $this->immagini; }
    public function addImmagine(EImmagine $immagine): void { $this->immagini[] = $immagine; }

    public function getTag(): array { return $this->tag; }
    public function addTag(ETag $tag): void { $this->tag[] = $tag; }

    public function getCommenti(): array { return $this->commenti; }
    public function addCommento(ECommento $commento): void { $this->commenti[] = $commento; }
}
?>