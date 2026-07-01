<?php

/**
 * La classe FCommento fornisce query per gli oggetti ECommento
 * @package Foundation
 */
class FCommento {

    private static $class = "FCommento";
    private static $table = "commento";
    private static $values = "(:id, :testo, :valutazione, :dataPubblicazione, :idAutore, :idOpera)";

    public function __construct() {}

    public static function bind($stmt, ECommento $commento) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':testo', $commento->getTesto(), PDO::PARAM_STR);
        $stmt->bindValue(':valutazione', $commento->getValutazione(), PDO::PARAM_INT);
        $stmt->bindValue(':dataPubblicazione', $commento->getData()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        // Estraiamo gli ID dagli oggetti associati
        $stmt->bindValue(':idAutore', $commento->getAutore()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':idOpera', $commento->getOpera()->getId(), PDO::PARAM_INT);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(ECommento $commento) {
        $db = FDatabase::getInstance();
        // Controlliamo che l'utente autore esista davvero prima di inserire
        $utenteEsiste = FUtente::exist("id", $commento->getAutore()->getId());
        if ($utenteEsiste) {
            return $db->storeDB(static::getClass(), $commento);
        }
        return false;
    }

public static function loadByField($field, $id) {
    $db     = FDatabase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!isset($result[0]) || !is_array($result[0])) {
        // Singolo record
        $autore = FUtente::loadByField("id", $result["idAutore"]);
        $opera  = FOpera::loadByField("id", $result["idOpera"]);
        return new ECommento(
            $result['id'], $result['testo'], $result['valutazione'],
            new DateTimeImmutable($result['dataPubblicazione']), $autore, $opera
        );
    }

    // Record multipli
    $commenti = [];
    foreach ($result as $row) {
        $autore = FUtente::loadByField("id", $row["idAutore"]);
        $opera  = FOpera::loadByField("id", $row["idOpera"]);
        $commenti[] = new ECommento(
            $row['id'], $row['testo'], $row['valutazione'],
            new DateTimeImmutable($row['dataPubblicazione']), $autore, $opera
        );
    }
    return $commenti;
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