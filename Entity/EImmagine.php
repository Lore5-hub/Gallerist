<?php

/*da ricontrollare*/
/**
 * Classe che modella le immagini di un'opera d'arte.
 * @package Entity
 */
class EImmagine {
    private string $urlFile;
    private bool $copertina; // Identifica l'immagine principale per le card del catalogo

    public function __construct(string $urlFile, bool $copertina) {
        $this->urlFile = $urlFile;
        $this->copertina = $copertina;
    }

    public function getUrlFile(): string { return $this->urlFile; }
    public function setUrlFile(string $urlFile): void { $this->urlFile = $urlFile; }

    public function isCopertina(): bool { return $this->copertina; }
    public function setCopertina(bool $copertina): void { $this->copertina = $copertina; }
}
?>