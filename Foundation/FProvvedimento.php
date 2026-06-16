<?php

/**
 * La classe FProvvedimento fornisce query per gli oggetti EProvvedimento
 * @package Foundation
 */
class FProvvedimento extends FDataBase {

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
        $provvedimento = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);

        if (($result != null) && ($rows_number == 1)) {
            $utente = FUtente::loadByField("id", $result["idUtenteSanzionato"]);
            $provvedimento = new EProvvedimento(
                $result['id'], $result['tipoBan'], $result['dataInizio'], 
                $result['dataFine'], $result['motivo'], $utente
            );
        } 
        else if (($result != null) && ($rows_number > 1)) {
            $provvedimento = array();
            for ($i = 0; $i < count($result); $i++) {
                $utente = FUtente::loadByField("id", $result[$i]["idUtenteSanzionato"]);
                $istanza = new EProvvedimento(
                    $result[$i]['id'], $result[$i]['tipoBan'], $result[$i]['dataInizio'], 
                    $result[$i]['dataFine'], $result[$i]['motivo'], $utente
                );
                $provvedimento[] = $istanza;
            }
        }
        return $provvedimento;
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