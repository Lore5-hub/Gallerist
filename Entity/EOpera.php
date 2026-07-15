<?php


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
    private EPrezzo $prezzo;
    private EStatoOpera $statoOpera; 
    // Es. "In vendita", "Venduta", "Riservata"
    private float $larghezza   = 0.0;
private float $altezza     = 0.0;
private float $profondita  = 0.0;
private string $unitaMisura = 'cm';
private int $idCategoria   = 0;
private int $idTecnica     = 0;

    // Associazioni dirette ed aggregazioni di tipo strutturato 
    private EArtista $artista;
    private ECategoria $categoria;
    private array $immagini = []; // Contiene oggetti di tipo EImmagine
    private array $tag = [];      // Contiene oggetti di tipo ETag
    private array $commenti = []; // Contiene oggetti di tipo ECommento
    
    public function __construct(
    int $id, string $titolo, int $anno, ETecnica $tecnica, string $dimensioni,
    string $descrizione, EPrezzo $prezzo, EStatoOpera $statoOpera = null,
    EArtista $artista, ECategoria $categoria,
    float $larghezza = 0.0, float $altezza = 0.0, float $profondita = 0.0,
    string $unitaMisura = 'cm', int $idCategoria = 0, int $idTecnica = 0
) {
    $this->id          = $id;
    $this->titolo      = $titolo;
    $this->anno        = $anno;
    $this->tecnica     = $tecnica;
    $this->dimensioni  = $dimensioni;
    $this->descrizione = $descrizione;
    $this->prezzo      = $prezzo;
    $this->artista     = $artista;
    $this->categoria   = $categoria;
    $this->statoOpera  = $statoOpera ?? new EStatoInserito();
    $this->larghezza   = $larghezza;
    $this->altezza     = $altezza;
    $this->profondita  = $profondita;
    $this->unitaMisura = $unitaMisura;
    $this->idCategoria = $idCategoria;
    $this->idTecnica   = $idTecnica;
}
    /**
     * Calcola dinamicamente la valutazione media ciclando sulle recensioni associate.
     
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
public function isVenduta(): bool {
    return $this->statoOpera instanceof EStatoVenduto;
}

public function isInVendita(): bool {
    return $this->statoOpera instanceof EStatoInVendita;
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
    public function getPrezzo(): EPrezzo { return $this->prezzo; }
    public function setPrezzo(EPrezzo $prezzo): void { $this->prezzo = $prezzo; }
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
    public function getLarghezza(): float   { return $this->larghezza; }
public function setLarghezza(float $v): void { $this->larghezza = $v; }

public function getAltezza(): float     { return $this->altezza; }
public function setAltezza(float $v): void { $this->altezza = $v; }

public function getProfondita(): float  { return $this->profondita; }
public function setProfondita(float $v): void { $this->profondita = $v; }

public function getUnitaMisura(): string { return $this->unitaMisura; }
public function setUnitaMisura(string $v): void { $this->unitaMisura = $v; }

public function getIdCategoria(): int  { return $this->idCategoria; }
public function setIdCategoria(int $v): void { $this->idCategoria = $v; }

public function getIdTecnica(): int    { return $this->idTecnica; }
public function setIdTecnica(int $v): void { $this->idTecnica = $v; }
}
?>