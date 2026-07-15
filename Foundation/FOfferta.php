<?php
// Foundation/FOfferta.php

/**
 * Classe Foundation per la gestione della persistenza dell'entità EOfferta.
 *
 * 
 *  - bind()            → lega i valori di EOfferta ai parametri PDO
 *  - store()           → INSERT via FDataBase::storeDB()
 *  - loadByField()     → SELECT con JOIN via FDataBase::queryDB()
 *  - exist/update/delete → operazioni CRUD generiche via FDataBase
 *
 * La query di load usa JOIN su UTENTE e OPERA per evitare il problema N+1
 * (stessa strategia di FOpera::loadByField).
 *
 * @package Foundation
 */
class FOfferta {

    private static string $class  = 'FOfferta';
    private static string $table  = 'offerta';
    private static string $values = '(:id, :cifraProposta, :nota, :stato, :dataOfferta, :idOfferente, :idOpera)';

    public function __construct() {}

    // -------------------------------------------------------------------------
    // Metodi richiesti da FDataBase::storeDB() e dal pattern Foundation
    // -------------------------------------------------------------------------

    /**
     * Lega i valori di EOfferta ai parametri dello statement PDO.
     * Chiamato internamente da FDataBase::storeDB().
     */
    public static function bind($stmt, EOfferta $offerta): void {
        $id = $offerta->getId();
        $stmt->bindValue(':id',            $id === 0 ? null : $id,                     $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':cifraProposta', $offerta->getCifraProposta()->getValore(),   PDO::PARAM_STR);
        $stmt->bindValue(':nota',          $offerta->getNota(),                         PDO::PARAM_STR);
        $stmt->bindValue(':stato',         $offerta->getStato(),                        PDO::PARAM_STR);
        $stmt->bindValue(':dataOfferta',   $offerta->getDataOfferta()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(':idOfferente',   $offerta->getOfferente()->getId(),            PDO::PARAM_INT);
        $stmt->bindValue(':idOpera',       $offerta->getOpera()->getId(),                PDO::PARAM_INT);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    // -------------------------------------------------------------------------
    // CRUD
    // -------------------------------------------------------------------------

    /**
     * Salva una nuova EOfferta nel database.
     *
     * @return string|null L'ID generato dal DB (lastInsertId), oppure null in caso di errore.
     */
    public static function store(EOfferta $offerta): ?string {
        $db = FDataBase::getInstance();
        return $db->storeDB(static::$class, $offerta);
    }

    /**
     * Carica una o più EOfferta dal database in base a un campo e valore.
     *
     * Usa una query con JOIN su UTENTE (offerente) e OPERA per ricavare
     * tutti i dati necessari alla costruzione degli oggetti in una sola query,
     * evitando il problema N+1 (stessa strategia di FOpera::loadByField).
     *
     * Campi JOIN aliasati per evitare conflitti:
     *  - offerente_id, offerente_nome, offerente_cognome, offerente_email,
     *    offerente_nickname
     *  - opera_id, opera_titolo, opera_prezzo, opera_stato, opera_idArtista
     *
     * NOTA: EOpera viene costruita con i soli campi disponibili dalla JOIN
     * (titolo, prezzo, stato, idArtista). Se nella view servissero altri
     * campi dell'opera (descrizione, anno…), aggiungere le colonne alla query.
     *
     * @param string $field  Nome del campo su cui filtrare (es. 'id', 'idOfferente', 'idOpera')
     * @param mixed  $val    Valore del filtro
     * @return EOfferta|EOfferta[]|null
     */
    public static function loadByField(string $field, mixed $val): mixed {
        $query = "SELECT
                      of.id,
                      of.cifraProposta,
                      of.nota,
                      of.stato,
                      of.dataOfferta,
                      u.id       AS offerente_id,
                      u.nome     AS offerente_nome,
                      u.cognome  AS offerente_cognome,
                      u.email    AS offerente_email,
                      u.nickname AS offerente_nickname,
                      o.id       AS opera_id,
                      o.titolo   AS opera_titolo,
                      o.prezzo   AS opera_prezzo,
                      o.statoOpera AS opera_stato,
                      o.idArtista  AS opera_idArtista
                  FROM " . static::$table . " of
                  INNER JOIN utente u ON of.idOfferente = u.id
                  INNER JOIN opera  o ON of.idOpera     = o.id
                  WHERE of." . $field . " = :val";

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, [':val' => $val]);

        if ($result === null) {
            return null;
        }

        if (count($result) === 1) {
            return self::creaOffertaDaArray($result[0]);
        }

        $offerte = [];
        foreach ($result as $row) {
            $offerte[] = self::creaOffertaDaArray($row);
        }
        return $offerte;
    }

    /**
     * Verifica l'esistenza di un record tramite un campo arbitrario.
     */
    public static function exist(string $field, mixed $val): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $val) !== null);
    }

    /**
     * Aggiorna un singolo attributo dell'offerta nel database.
     */
    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    /**
     * Elimina un'offerta dal database tramite un campo e valore.
     */
    public static function delete(string $field, mixed $val): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $val);
    }

    // -------------------------------------------------------------------------
    // Helper privato
    // -------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di EOfferta (con EUtente e EOpera annidati)
     * a partire da un array prodotto dalla query JOIN di loadByField().
     *
     * NOTA: EUtente (offerente) ed EOpera vengono costruiti con i soli campi
     * disponibili dalla JOIN. 
     */
    private static function creaOffertaDaArray(array $row): EOfferta {
        // Offerente: solo i campi estratti dalla JOIN
        $offerente = new EUtente(
    (int) $row['offerente_id'],
    $row['offerente_nome'],
    $row['offerente_cognome'],
    new DateTimeImmutable('1990-01-01'), 
    '',
    $row['offerente_nickname'],
    '+39 0000000000', // ← placeholder valido
    $row['offerente_email'],
    '',
    null,
    EUtente::STATO_ATTIVO,
    EUtente::RUOLO_USER
);

        // Opera: solo i campi essenziali estratti dalla JOIN
        // EArtista placeholder con il solo ID, sufficiente per le FK
        $artistaPlaceholder = new EArtista(
    (int) $row['opera_idArtista'],
    '', '',
    new DateTimeImmutable('1990-01-01'), 
    '', '', '+39 0000000000', '', '', null,
    '', '', '',
    EArtista::STATO_IN_ATTESA
);

        $opera = new EOpera(
    (int) $row['opera_id'],              
    $row['opera_titolo'],
    0,
    new ETecnica(0, ''),
    '',
    '',
    new EPrezzo((float) $row['opera_prezzo'], 'EUR'),
    null,
    $artistaPlaceholder,
    new ECategoria('')
);
        

        return new EOfferta(
            (int) $row['id'],
            new EPrezzo((float) $row['cifraProposta']),
            $row['nota'],
            $row['stato'],
            new DateTimeImmutable($row['dataOfferta']),
            $offerente,
            $opera
        );
    }
}
?>