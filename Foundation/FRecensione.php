<?php

/**
 * La classe FRecensione fornisce query per gli oggetti ERecensione (UC4)
 * @package Foundation
 */
class FRecensione {
    
    private static $class = "FRecensione";
    private static $table = "recensione";
    private static $values = "(:id, :testo, :voto, :idUtente, :idOpera)";

    public function __construct() {}

    public static function bind($stmt, ERecensione $recensione) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT); // ID Auto-increment
        $stmt->bindValue(':testo', $recensione->getTesto(), PDO::PARAM_STR);
        $stmt->bindValue(':voto', $recensione->getVoto(), PDO::PARAM_INT);
        // Estraiamo gli ID degli oggetti correlati per le chiavi esterne
        $stmt->bindValue(':idUtente', $recensione->getUtente()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':idOpera', $recensione->getOpera()->getId(), PDO::PARAM_INT);
    }

    public static function getClass() {
        return static::$class;
    }

    public static function getTable() {
        return static::$table;
    }

    public static function getValues() {
        return static::$values;
    }

    public static function store(ERecensione $recensione) {
        $db = FDatabase::getInstance();
        // Verifica preliminare dell'esistenza dell'utente e dell'opera (stile codice esempio)
        $utenteEsiste = FUtente::exist("id", $recensione->getUtente()->getId());
        $operaEsiste = FOpera::exist("id", $recensione->getOpera()->getId());
        
        if ($utenteEsiste && $operaEsiste) {
            $id = $db->storeDB(static::getClass(), $recensione);
            return $id;
        }
        return false;
    }

    public static function loadByField($field, $id) {
    $db     = FDatabase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!is_array($result[0])) {
        // Singolo record
        $ute = FUtente::loadByField("id", $result["idUtente"]);
        $ope = FOpera::loadByField("id", $result["idOpera"]);
        $recensione = new ERecensione($result['testo'], $result['voto'], $ute, $ope);
        $recensione->setId($result['id']);
        return $recensione;
    }

    // Record multipli
    $recensioni = [];
    foreach ($result as $row) {
        $ute = FUtente::loadByField("id", $row["idUtente"]);
        $ope = FOpera::loadByField("id", $row["idOpera"]);
        $istanza = new ERecensione($row['testo'], $row['voto'], $ute, $ope);
        $istanza->setId($row['id']);
        $recensioni[] = $istanza;
    }
    return $recensioni;
}

    public static function exist($field, $id) {
        $db = FDatabase::getInstance();
        $result = $db->existDB(static::getClass(), $field, $id);
        return ($result != null);
    }

    public static function update($field, $newvalue, $pk, $id) {
        $db = FDatabase::getInstance();
        return $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
    }

    public static function delete($field, $id) {
        $db = FDatabase::getInstance();
        return $db->deleteDB(static::getClass(), $field, $id);
    }
}
?>