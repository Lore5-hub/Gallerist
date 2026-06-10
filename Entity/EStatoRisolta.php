<?php
/**
 * Stato finale: La segnalazione è stata accolta ed è stato preso un provvedimento (es. Ban o Rimozione).
 */
class EStatoRisolta extends EStatoSegnalazione {
    private string $provvedimento preso; // Memorizza la nota sul provvedimento amministrativo

    public function __construct(string $provvedimento) {
        $this->nomeStato = "Risolta con Provvedimento";
        $this->provvedimentoPreso = $provvedimento;
    }
    public function getProvvedimentoPreso(): string { return $this->provvedimentoPreso; }
}