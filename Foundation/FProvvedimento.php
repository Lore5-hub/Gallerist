<?php

/**
 * La classe FProvvedimento fornisce query per gli oggetti EProvvedimento
 * @package Foundation
 */
class FProvvedimento {

    private static $class = "FProvvedimento";
    private static $table = "provvedimento";
    private static $values = "(:id, :tipoBan, :dataInizio, :dataFine, :motivo, :idUtenteSanzionato)";

    public function __construct() {}

    public static function bind($stmt, EProvvedimento $provvedimento) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':tipoBan', $provvedimento->getTipoBan(), PDO::PARAM_STR);
        $stmt->bindValue(':dataInizio', $provvedimento->getDataInizio(), PDO::PARAM_STR);
        $stmt->bindValue(':dataFine', $provvedimento->getDataFine(), PDO::PARAM_STR);
        $stmt->bindValue(':motivo', $provvedimento->getMotivo(), PDO::PARAM_STR);
        $stmt->bindValue(':idUtenteSanzionato', $provvedimento->getUtenteSanzionato()->getId(), PDO::PARAM_INT);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(EProvvedimento $provvedimento) {
        $db = FDatabase::getInstance();
        $utenteEsiste = FUtente::exist("id", $provvedimento->getUtenteSanzionato()->getId());
        if ($utenteEsiste) {
            return $db->storeDB(static::getClass(), $provvedimento);
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
        $utente = FUtente::loadByField("id", $result["idUtenteSanzionato"]);
        return new EProvvedimento(
            $result['id'], $result['tipoBan'], $result['dataInizio'],
            $result['dataFine'], $result['motivo'], $utente
        );
    }

    // Record multipli
    $provvedimenti = [];
    foreach ($result as $row) {
        $utente = FUtente::loadByField("id", $row["idUtenteSanzionato"]);
        $provvedimenti[] = new EProvvedimento(
            $row['id'], $row['tipoBan'], $row['dataInizio'],
            $row['dataFine'], $row['motivo'], $utente
        );
    }
    return $provvedimenti;
}

    public static function exist($field, $id) {
        $db = FDatabase::getInstance();
        return ($db->existDB(static::getClass(), $field, $id) != null);
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