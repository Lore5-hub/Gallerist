<?php
class CErrore {
    public function mostra404(): void {
        header("HTTP/1.0 404 Not Found");
        $vErrore = new VErrore();
        $vErrore->mostraErrore('Pagina non trovata', 'La pagina che cerchi non esiste.', '404');
    }
}