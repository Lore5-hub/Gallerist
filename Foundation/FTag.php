<?php
// Foundation/FTag.php

/**
 * Classe Foundation per la persistenza di ETag.
 *
 * ARCHITETTURA MANY-TO-MANY:
 * La relazione opera-tag è gestita da due tabelle:
 *   - `tag`      (id, nome)         — anagrafica dei tag
 *   - `opera_tag` (idOpera, idTag)  — tabella di join
 *
 * FTag si occupa di entrambe. Il metodo principale per CCatalogo è
 * loadByOpera(), che recupera tutti i tag di un'opera con una JOIN.
 * I metodi store/delete gestiscono sia l'anagrafica che la join.
 *
 * loadByField() è mantenuto per compatibilità con FPersistentManager::load(),
 * ma opera sulla tabella `tag` (anagrafica); per i tag di un'opera
 * usare loadByOpera() o FPersistentManager::load('ETag', 'idOpera', $id)
 * che viene intercettato e reindirizzato a loadByOpera().
 *
 * @package Foundation
 */
class FTag {

    private static string $class      = 'FTag';
    private static string $table      = 'tag';
    private static string $tableJoin  = 'opera_tag';
    private static string $values     = '(:id, :nome)';

    public function __construct() {}

    // -------------------------------------------------------------------------
    // Interfaccia richiesta da FDataBase::storeDB()
    // -------------------------------------------------------------------------

    public static function bind($stmt, ETag $tag): void {
        $id = $tag->getId();
        $stmt->bindValue(':id',   $id === 0 ? null : $id, $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':nome', $tag->getNomeTag(),      PDO::PARAM_STR);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    // -------------------------------------------------------------------------
    // CRUD
    // -------------------------------------------------------------------------

    /**
     * Salva un ETag nel DB (anagrafica) e lo collega all'opera tramite opera_tag.
     *
     * Se un tag con lo stesso nome esiste già, riusa l'ID esistente anziché
     * crearne uno duplicato, poi crea comunque il record in opera_tag.
     *
     * @param ETag $tag     Il tag da salvare
     * @param int  $idOpera L'opera a cui collegare il tag
     * @return string|null  L'ID del tag (nuovo o esistente), null in caso di errore
     */
    public static function store(ETag $tag, int $idOpera): ?string {
        $db = FDataBase::getInstance();

        // 1. Cerca se il tag esiste già per evitare duplicati in anagrafica
        $esistente = $db->queryDB(
            "SELECT id FROM " . static::$table . " WHERE nome = :nome LIMIT 1",
            [':nome' => $tag->getNomeTag()]
        );

        if ($esistente !== null && count($esistente) > 0) {
            $idTag = (int) $esistente[0]['id'];
        } else {
            // 2a. Inserisce il nuovo tag in anagrafica
            $idTag = $db->storeDB(static::$class, $tag);
            if ($idTag === null) {
                return null;
            }
            $idTag = (int) $idTag;
        }

        // 2b. Crea il legame in opera_tag (solo se non esiste già)
        $legameEsiste = $db->queryDB(
            "SELECT 1 FROM " . static::$tableJoin . " WHERE idOpera = :idOpera AND idTag = :idTag",
            [':idOpera' => $idOpera, ':idTag' => $idTag]
        );

        if ($legameEsiste === null || count($legameEsiste) === 0) {
            $db->queryDB(
                "INSERT INTO " . static::$tableJoin . " (idOpera, idTag) VALUES (:idOpera, :idTag)",
                [':idOpera' => $idOpera, ':idTag' => $idTag]
            );
        }

        return (string) $idTag;
    }

    /**
     * Carica tutti i tag associati a una specifica opera tramite JOIN.
     * Questo è il metodo usato da CCatalogo e da FPersistentManager::load('ETag', 'idOpera', $id).
     *
     * @param int $idOpera ID dell'opera
     * @return ETag[] Array (anche vuoto) di oggetti ETag
     */
    public static function loadByOpera(int $idOpera): array {
        $db = FDataBase::getInstance();

        $result = $db->queryDB(
            "SELECT t.id, t.nome
             FROM " . static::$table . " t
             INNER JOIN " . static::$tableJoin . " ot ON t.id = ot.idTag
             WHERE ot.idOpera = :idOpera
             ORDER BY t.nome ASC",
            [':idOpera' => $idOpera]
        );

        if ($result === null) {
            return [];
        }

        $tags = [];
        foreach ($result as $row) {
            $tags[] = new ETag((int) $row['id'], $row['nome']);
        }
        return $tags;
    }

    /**
     * Carica tag dall'anagrafica per campo (es. 'id', 'nome').
     * Per i tag di un'opera usare loadByOpera() o il campo 'idOpera' tramite Manager.
     *
     * @param string $field  Campo su cui filtrare
     * @param mixed  $val    Valore del filtro. Se $field === 'idOpera', delega a loadByOpera()
     * @return ETag|ETag[]|null
     */
    public static function loadByField(string $field, mixed $val): mixed {
        // Intercetta il campo 'idOpera' che non esiste in `tag` ma viene
        // usato da FPersistentManager::load('ETag', 'idOpera', $id)
        if ($field === 'idOpera') {
            return self::loadByOpera((int) $val);
        }

        $db     = FDataBase::getInstance();
        $result = $db->loadDB(static::$class, $field, $val);

        if ($result === null) {
            return null;
        }

        // Singolo record (array associativo piatto)
        if (!isset($result[0]) || !is_array($result[0])) {
            return new ETag((int) $result['id'], $result['nome']);
        }

        $tags = [];
        foreach ($result as $row) {
            $tags[] = new ETag((int) $row['id'], $row['nome']);
        }
        return $tags;
    }

    public static function exist(string $field, mixed $val): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $val) !== null);
    }

    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    /**
     * Rimuove il legame opera-tag da opera_tag.
     * Per eliminare il tag dall'anagrafica usare delete('id', $idTag).
     *
     * @param string $field  'idOpera' per rimuovere tutti i tag di un'opera,
     *                       'id' per eliminare un tag dall'anagrafica
     * @param mixed  $val    Valore del filtro
     */
    public static function delete(string $field, mixed $val): ?bool {
        $db = FDataBase::getInstance();

        if ($field === 'idOpera') {
            // Rimuove tutti i legami opera_tag per quell'opera
            $result = $db->queryDB(
                "DELETE FROM " . static::$tableJoin . " WHERE idOpera = :val",
                [':val' => $val]
            );
            return $result !== null;
        }

        return $db->deleteDB(static::$class, $field, $val);
    }
}
?>