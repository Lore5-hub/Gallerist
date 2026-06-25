<?php

/**
 * Classe Foundation per la persistenza di ERecensione (UC4).
 *
 * INCOERENZE RISOLTE rispetto al codice originale del professore:
 *
 * 1. $table: era "recensione" (tabella inesistente) → corretto in "commento",
 *    che è la tabella SQL reale del progetto.
 *
 * 2. $values: le colonne erano (:id,:testo,:voto,:idUtente,:idOpera).
 *    La tabella `commento` ha invece: id, testo, valutazione,
 *    dataPubblicazione, idAutore, idOpera. Allineato di conseguenza.
 *
 * 3. FDatabase → FDataBase: corretto il bug storico del progetto
 *    (la classe si chiama FDataBase, non FDatabase).
 *
 * 4. bind(): era $recensione->getUtente() → corretto in getAutore(),
 *    metodo ereditato da ECommento. Aggiunta la colonna dataPubblicazione.
 *
 * 5. loadByField(): era N+1 (una query per utente + opera per ogni riga)
 *    → riscritto con JOIN su utente e opera, come FOpera e FOfferta.
 *    Costruttore di ERecensione era sbagliato (argomenti mancanti e
 *    ordine errato) → allineato alla firma reale di ERecensione.
 *
 * @package Foundation
 */
class FRecensione {

    private static string $class  = 'FRecensione';
    private static string $table  = 'commento';   // FIX: era "recensione", tabella inesistente
    private static string $values = '(:id, :testo, :valutazione, :dataPubblicazione, :idAutore, :idOpera)';

    public function __construct() {}

    // -------------------------------------------------------------------------
    // Interfaccia richiesta da FDataBase::storeDB()
    // -------------------------------------------------------------------------

    public static function bind($stmt, ERecensione $recensione): void {
        $id = $recensione->getId();
        $stmt->bindValue(':id',               $id === 0 ? null : $id,                        $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':testo',            $recensione->getTesto(),                        PDO::PARAM_STR);
        $stmt->bindValue(':valutazione',      $recensione->getValutazione(),                  PDO::PARAM_INT); // FIX: era :voto
        $stmt->bindValue(':dataPubblicazione', $recensione->getData()->format('Y-m-d H:i:s'), PDO::PARAM_STR); // FIX: colonna mancante
        $stmt->bindValue(':idAutore',         $recensione->getAutore()->getId(),              PDO::PARAM_INT); // FIX: era getUtente()
        $stmt->bindValue(':idOpera',          $recensione->getOpera()->getId(),               PDO::PARAM_INT);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    // -------------------------------------------------------------------------
    // CRUD
    // -------------------------------------------------------------------------

    /**
     * Salva una nuova ERecensione nel database.
     * Verifica l'esistenza di utente e opera prima di procedere.
     *
     * @return string|null ID generato dal DB, null in caso di errore.
     */
    public static function store(ERecensione $recensione): ?string {
        $db = FDataBase::getInstance(); // FIX: era FDatabase (maiuscola mancante)

        if (!FUtente::exist('id', $recensione->getAutore()->getId())) {  // FIX: era getUtente()
            error_log('FRecensione::store - Autore non esistente, id: ' . $recensione->getAutore()->getId());
            return null;
        }
        if (!FOpera::exist('id', $recensione->getOpera()->getId())) {
            error_log('FRecensione::store - Opera non esistente, id: ' . $recensione->getOpera()->getId());
            return null;
        }

        return $db->storeDB(static::$class, $recensione);
    }

    /**
     * Carica una o più ERecensione dal database tramite JOIN.
     *
     * Usa JOIN su utente e opera per evitare il problema N+1
     * (stessa strategia di FOpera, FOfferta).
     *
     * @param string $field  'id', 'idAutore', 'idOpera'
     * @param mixed  $val    Valore del filtro
     * @return ERecensione|ERecensione[]|null
     */
    public static function loadByField(string $field, mixed $val): mixed {
        $query = "SELECT
                      c.id,
                      c.testo,
                      c.valutazione,
                      c.dataPubblicazione,
                      u.id       AS autore_id,
                      u.nome     AS autore_nome,
                      u.cognome  AS autore_cognome,
                      u.email    AS autore_email,
                      u.nickname AS autore_nickname,
                      o.id       AS opera_id,
                      o.titolo   AS opera_titolo,
                      o.prezzo   AS opera_prezzo,
                      o.statoOpera AS opera_stato,
                      o.idArtista  AS opera_idArtista
                  FROM " . static::$table . " c
                  INNER JOIN utente u ON c.idAutore = u.id
                  INNER JOIN opera  o ON c.idOpera  = o.id
                  WHERE c." . $field . " = :val";

        $db     = FDataBase::getInstance(); // FIX: era FDatabase
        $result = $db->queryDB($query, [':val' => $val]);

        if ($result === null) {
            return null;
        }

        if (count($result) === 1) {
            return self::creaRecensioneDaArray($result[0]);
        }

        $recensioni = [];
        foreach ($result as $row) {
            $recensioni[] = self::creaRecensioneDaArray($row);
        }
        return $recensioni;
    }

    public static function exist(string $field, mixed $val): bool {
        $db = FDataBase::getInstance(); // FIX: era FDatabase
        return ($db->existDB(static::$class, $field, $val) !== null);
    }

    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance(); // FIX: era FDatabase
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    public static function delete(string $field, mixed $val): ?bool {
        $db = FDataBase::getInstance(); // FIX: era FDatabase
        return $db->deleteDB(static::$class, $field, $val);
    }

    // -------------------------------------------------------------------------
    // Helper privato
    // -------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di ERecensione a partire da un array della query JOIN.
     * FIX: il codice originale chiamava new ERecensione($testo, $voto, $ute, $ope)
     * con firma e ordine sbagliati. La firma corretta è:
     * ERecensione(int $id, string $testo, int $valutazione, DateTimeImmutable $data,
     *             EUtente $autore, EOpera $opera)
     */
    private static function creaRecensioneDaArray(array $row): ERecensione {
        $autore = new EUtente(
            (int) $row['autore_id'],
            $row['autore_nome'],
            $row['autore_cognome'],
            '', '', // dataNascita, indirizzo: non estratti
            $row['autore_nickname'],
            '',     // telefono: non estratto
            $row['autore_email'],
            '',     // password: mai esposta
            null,
            EUtente::STATO_ATTIVO
        );

        $artistaPlaceholder = new EArtista(
            (int) $row['opera_idArtista'],
            '', '', '', '', '', '', '', '', null,
            EUtente::STATO_ATTIVO, '', '', '',
            EArtista::STATO_IN_ATTESA
        );

        $opera = new EOpera(
            $row['opera_titolo'],
            0, '', 0.0, 0.0, 0.0, '', '', '',
            (float) $row['opera_prezzo'],
            $row['opera_stato'],
            $artistaPlaceholder
        );
        $opera->setId((int) $row['opera_id']);

        return new ERecensione(
            (int) $row['id'],
            $row['testo'],
            (int) $row['valutazione'],
            new DateTimeImmutable($row['dataPubblicazione']),
            $autore,
            $opera
        );
    }
}
?>