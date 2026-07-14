<?php
// Entity/EImmagine.php

/**
 * Modella un'immagine associata a un'opera d'arte.
 *
 * NOTA ARCHITETTURALE — copertina e dati binari:
 *
 * La tabella `immagine` sul DB salva solo `nome_file` (path relativo) e `idOpera`.
 * Non esiste una colonna `copertina`: per convenzione del progetto la copertina
 * è la PRIMA immagine dell'array restituito da EOpera::getImmagini() (cfr. VCatalogo).
 *
 * Le View (VCatalogo, VOpera, VCompravendita) chiamano getData() e getType()
 * per ottenere i byte grezzi e il MIME type da codificare in Base64.
 * getData() legge il file dal disco tramite il path in $urlFile; getType() lo
 * ricava dall'estensione. Questo approccio è coerente con il pattern già usato
 * nelle View e non richiede di salvare i binari nel DB.
 *
 * $id è necessario per le operazioni Foundation (update, delete per PK).
 *
 * @package Entity
 */
class EImmagine {

    private int    $id;
    private string $urlFile;  // path relativo al file (es. "uploads/opere/123.jpg")

    /**
     * @param int    $id      0 per nuovi inserimenti (AUTO_INCREMENT)
     * @param string $urlFile Path relativo al file immagine sul server
     */
    public function __construct(int $id, string $urlFile) {
        $this->id      = $id;
        $this->urlFile = $urlFile;
    }

    public function getId(): int             { return $this->id; }
    public function setId(int $id): void     { $this->id = $id; }

    public function getUrlFile(): string              { return $this->urlFile; }
    public function setUrlFile(string $urlFile): void { $this->urlFile = $urlFile; }

    /**
     * Restituisce i byte grezzi del file immagine letti dal disco.
     * Chiamato da VCatalogo, VOpera e VCompravendita per la codifica Base64.
     *
     * @return string|null Contenuto binario del file, oppure null se il file non esiste.
     */
    public function getData(): ?string {
    // Prova prima il path assoluto, poi relativo
    $pathAssoluto = $_SERVER['DOCUMENT_ROOT'] . '/Gallerist/uploads/opere/' . basename($this->urlFile);
    
    if (file_exists($pathAssoluto)) {
        return file_get_contents($pathAssoluto);
    }
    
    // Fallback path relativo
    if (file_exists($this->urlFile)) {
        return file_get_contents($this->urlFile);
    }
    
    return null;
}

    /**
     * Restituisce il MIME type dell'immagine ricavato dall'estensione del file.
     * Chiamato da VCatalogo, VOpera e VCompravendita insieme a getData().
     *
     * @return string MIME type (es. 'image/jpeg'), oppure 'image/jpeg' come fallback.
     */
    public function getType(): string {
        $estensione = strtolower(pathinfo($this->urlFile, PATHINFO_EXTENSION));
        $mimeMap = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
        ];
        return $mimeMap[$estensione] ?? 'image/jpeg';
    }

    
}
?>