<?php
// Foundation/FImmagine.php

/**
 * Classe Foundation per la persistenza di EImmagine.
 *
 * La tabella `immagine` ha: id (PK AUTO_INCREMENT), nome_file, idOpera.
 * Non esiste una colonna `copertina`: la copertina è la prima immagine
 * dell'array per convenzione del progetto (cfr. EImmagine, VCatalogo).
 *
 * EImmagine non conosce il proprio idOpera (FK): viene passato esplicitamente
 * a store() perché non è responsabilità dell'Entity portare la propria FK.
 *
 * Le View chiamano getData() e getType() su EImmagine per la codifica Base64.
 * FImmagine si occupa solo di persistenza; la lettura del file binario
 * è responsabilità di EImmagine::getData().
 *
 * @package Foundation
 */
class FImmagine {

    private static string $class  = 'FImmagine';
    private static string $table  = 'immagine';
    private static string $values = '(:id, :nome_file, :idOpera)';

    public function __construct() {}

    // -------------------------------------------------------------------------
    // Interfaccia richiesta da FDataBase::storeDB()
    // Nota: bind() non viene usato direttamente da store() in questa classe
    // (store usa queryDB direttamente per gestire idOpera esterno all'entity),
    // ma è richiesto dal contratto del pattern Foundation.
    // -------------------------------------------------------------------------

    public static function bind($stmt, EImmagine $immagine): void {
        $id = $immagine->getId();
        $stmt->bindValue(':id',       $id === 0 ? null : $id, $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':nome_file', $immagine->getUrlFile(), PDO::PARAM_STR);
        $stmt->bindValue(':idOpera',   null, PDO::PARAM_NULL); // placeholder; idOpera va passato a store()
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    // -------------------------------------------------------------------------
    // CRUD
    // -------------------------------------------------------------------------

    /**
     * Salva una nuova EImmagine nel database collegandola all'opera.
     *
     * idOpera è un parametro esplicito perché EImmagine non lo conosce:
     * è responsabilità del chiamante (Control o Foundation superiore) fornirlo.
     *
     * @param EImmagine $immagine  L'immagine da salvare
     * @param int       $idOpera   FK verso la tabella opera
     * @return string|null         ID generato dal DB, null in caso di errore
     */
    public static function store(EImmagine $immagine, int $idOpera): ?string {
        $db = FDataBase::getInstance();

        $result = $db->queryDB(
            "INSERT INTO " . static::$table . " (nome_file, idOpera) VALUES (:nome_file, :idOpera)",
            [':nome_file' => $immagine->getUrlFile(), ':idOpera' => $idOpera]
        );

        if ($result === null) {
            return null;
        }

        // queryDB non restituisce il lastInsertId direttamente;
        // lo recuperiamo rileggendo l'ultimo record inserito per questo file
        $inserted = $db->queryDB(
            "SELECT id FROM " . static::$table . " WHERE nome_file = :nome_file AND idOpera = :idOpera ORDER BY id DESC LIMIT 1",
            [':nome_file' => $immagine->getUrlFile(), ':idOpera' => $idOpera]
        );

        return ($inserted !== null && count($inserted) > 0) ? (string) $inserted[0]['id'] : null;
    }

    /**
     * Carica le immagini di un'opera (o una singola immagine per id).
     * La prima immagine restituita per 'idOpera' è la copertina (ordine di inserimento).
     *
     * @param string $field  'idOpera' per tutte le immagini di un'opera, 'id' per una specifica
     * @param mixed  $val    Valore del filtro
     * @return EImmagine|EImmagine[]|null
     */
    public static function loadByField(string $field, mixed $val): mixed {
        $db     = FDataBase::getInstance();
        $result = $db->loadDB(static::$class, $field, $val);

        if ($result === null) {
            return null;
        }

        // Singolo record: loadDB restituisce array piatto (non annidato)
        if (!isset($result[0]) || !is_array($result[0])) {
            return self::creaImmagine($result);
        }

        $immagini = [];
        foreach ($result as $row) {
            $immagini[] = self::creaImmagine($row);
        }
        return $immagini;
    }

    public static function exist(string $field, mixed $val): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $val) !== null);
    }

    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    public static function delete(string $field, mixed $val): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $val);
    }

    // -------------------------------------------------------------------------
    // Helper privato
    // -------------------------------------------------------------------------

    private static function creaImmagine(array $row): EImmagine {
        return new EImmagine((int) $row['id'], $row['nome_file']);
    }
}
?>