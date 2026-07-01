<?php
/**
 * Stato: Opera inserita solo per esposizione (Social).
 */
class EStatoInserito extends EStatoOpera {
    public function __construct()
    {
        $this->nomeStato = "Solo Esposizione";
    }

    public function isVendibile(): bool
    {
        return false;
    }

    public function puoEssereModificata(): bool
    {
        return true;
    }
    public function getNomeStato(): string { return 'pubblicata'; }

}