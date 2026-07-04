<?php
class EVisita {
    private int $id;
    private string $pagina;
    private DateTimeImmutable $data;
    private string $sessione;

    public function __construct(int $id, string $pagina, DateTimeImmutable $data, string $sessione) {
        $this->id       = $id;
        $this->pagina   = $pagina;
        $this->data     = $data;
        $this->sessione = $sessione;
    }

    public function getId(): int                  { return $this->id; }
    public function getPagina(): string           { return $this->pagina; }
    public function getData(): DateTimeImmutable  { return $this->data; }
    public function getSessione(): string         { return $this->sessione; }
}
?>