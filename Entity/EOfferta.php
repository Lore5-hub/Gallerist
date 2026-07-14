<?php


/**
 * Classe che modella una proposta di acquisto alternativa inviata da un utente.
 * @package Entity
 */
class EOfferta {

    // FIX: costanti di stato per evitare stringhe magiche nel Control e nella Foundation,
    // coerente con EUtente::STATO_ATTIVO e EArtista::STATO_IN_ATTESA
    public const STATO_INVIATA   = 'inviata';
    public const STATO_ACCETTATA = 'accettata';
    public const STATO_RIFIUTATA = 'rifiutata';

    private int              $id;
    private EPrezzo          $cifraProposta;  // FIX: float → EPrezzo, coerente con EOrdine
    private string           $nota;
    private string           $stato;
    private DateTimeImmutable $dataOfferta;   // FIX: string → DateTimeImmutable, coerente con EOrdine

    // Associazioni ad oggetti del dominio
    private EUtente $offerente;
    private EOpera  $opera;

    public function __construct(
        int              $id,
        EPrezzo          $cifraProposta,
        string           $nota,
        string           $stato,
        DateTimeImmutable $dataOfferta,
        EUtente          $offerente,
        EOpera           $opera
    ) {
        $this->id            = $id;
        $this->cifraProposta = $cifraProposta;
        $this->nota          = $nota;
        $this->setStato($stato);  // Validazione immediata tramite il setter
        $this->dataOfferta   = $dataOfferta;
        $this->offerente     = $offerente;
        $this->opera         = $opera;
    }

    // --- GETTER & SETTER ---

    public function getId(): int { return $this->id; }
    // FIX: aggiunto setId() mancante — necessario dopo lastInsertId() nella Foundation
    public function setId(int $id): void { $this->id = $id; }

    public function getCifraProposta(): EPrezzo { return $this->cifraProposta; }
    public function setCifraProposta(EPrezzo $cifraProposta): void { $this->cifraProposta = $cifraProposta; }

    public function getNota(): string { return $this->nota; }
    public function setNota(string $nota): void { $this->nota = $nota; }

    public function getStato(): string { return $this->stato; }
    /**
     * FIX: validazione dello stato nel setter — l'oggetto rifiuta valori non previsti.
     * Richiamato anche dal costruttore per garantire coerenza fin dalla creazione.
     * @throws InvalidArgumentException se lo stato non è tra quelli consentiti
     */
    public function setStato(string $stato): void {
        $statiValidi = [self::STATO_INVIATA, self::STATO_ACCETTATA, self::STATO_RIFIUTATA];
        if (!in_array($stato, $statiValidi, true)) {
            throw new InvalidArgumentException("Stato offerta non valido: '$stato'.");
        }
        $this->stato = $stato;
    }

    public function getDataOfferta(): DateTimeImmutable { return $this->dataOfferta; }
    public function setDataOfferta(DateTimeImmutable $dataOfferta): void { $this->dataOfferta = $dataOfferta; }

    public function getOfferente(): EUtente { return $this->offerente; }
    public function setOfferente(EUtente $offerente): void { $this->offerente = $offerente; }

    public function getOpera(): EOpera { return $this->opera; }
    public function setOpera(EOpera $opera): void { $this->opera = $opera; }
}
?>