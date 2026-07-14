<?php


/**
 * Classe Foundation per la gestione della persistenza dell'entità Categoria.
 *
 * Note architetturali:
 *  - La tabella CATEGORIA ha un'unica colonna: nome (PK stringa).
 *    Non esiste un id numerico, quindi bind() non gestisce alcun :id.
 *  - update() è assente intenzionalmente: il nome è la PK, modificarlo
 *    avrebbe effetti a cascata su tutte le opere collegate e va gestito
 *    con una transazione dedicata nel Control se necessario.
 *  - loadOpereByCategoria() è in FOpera (non qui): restituisce EOpera,
 *    quindi è responsabilità di FOpera costruirli (principio SRP).
 *
 * @package Foundation
 */
class FCategoria {

    private static string $class  = "FCategoria";
    private static string $table  = "categoria";
    private static string $values = "(:id,:nome,:descrizione)";

    public function __construct() {}

    /**
     * Lega i valori di ECategoria ai parametri dello statement PDO.
     * Chiamato internamente da FDataBase::storeDB().
     */
    public static function bind($stmt, ECategoria $categoria): void {
        $stmt->bindValue(':id',          NULL,                      PDO::PARAM_NULL);
        $stmt->bindValue(':nome', $categoria->getNome(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $categoria->getDescrizione() ?? '', PDO::PARAM_STR);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    /**
     * Salva una nuova Categoria nel database.
     * Usato solo dall'admin (CGestionePiattaforma).
     *
     * @return string|null Il nome inserito oppure null in caso di errore.
     */
    public static function store(ECategoria $categoria): ?string {
        $db = FDataBase::getInstance();
        return $db->storeDB(static::$class, $categoria);
    }

    /**
     * Carica una o più Categorie dal database in base a un campo e valore.
     * Nella maggior parte dei casi il campo sarà 'nome' (PK).
     * @return ECategoria|ECategoria[]|null
     */
    public static function loadByField(string $field, mixed $id): mixed {
        $db     = FDataBase::getInstance();
        $result = $db->loadDB(static::$class, $field, $id);

        if ($result === null) {
            return null;
        }

        // Record singolo → array associativo piatto (primo elemento NON è un sotto-array)
        if (!isset($result[0]) || !is_array($result[0])) {
            return self::creaEntitaDaArray($result);
        }

        // Record multipli → array di array associativi
        $categorie = [];
        foreach ($result as $row) {
            $categorie[] = self::creaEntitaDaArray($row);
        }
        return $categorie;
    }

    /**
     * Verifica l'esistenza di una categoria tramite un campo arbitrario.
     */
    public static function exist(string $field, mixed $id): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $id) !== null);
    }

    /**
     * Elimina una categoria dal database tramite un campo e valore.
     * Usato solo dall'admin (CGestionePiattaforma).
     *
     * ATTENZIONE: se sul DB è definito ON DELETE RESTRICT sulla FK
     * tra OPERA.categoria e CATEGORIA.nome, l'eliminazione fallirà
     * finché esistono opere associate. Gestire l'errore lato Control.
     */
    public static function delete(string $field, mixed $id): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $id);
    }

    /**
     * Carica tutte le categorie presenti nel database.
     * Usato da CCatalogo::esploraCatalogo() per popolare la sidebar dei filtri.
     * @return ECategoria[]|null Array di tutte le categorie oppure null se vuoto
     */
    public static function loadAll(): ?array {
        $query  = "SELECT * FROM " . static::$table . " ORDER BY nome ASC";
        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, []);

        if ($result === null) {
            return null;
        }

        $categorie = [];
        foreach ($result as $row) {
            $categorie[] = self::creaEntitaDaArray($row);
        }
        return $categorie;
    }

    // ---------------------------------------------------------------------------
    // Metodo privato di supporto
    // ---------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di ECategoria da un array associativo del DB.
     */
    private static function creaEntitaDaArray(array $row): ECategoria {
        return new ECategoria($row['nome'], $row['descrizione'] ?? '');
    }
    public static function getIdByNome(string $nome): int {
    $db     = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT id FROM categoria WHERE nome = :nome",
        [':nome' => $nome]
    );
    return !empty($result) ? (int)$result[0]['id'] : 0;
}
}
?>