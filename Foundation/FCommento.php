<?php

/**
 * La classe FCommento fornisce query per gli oggetti ECommento
 * @package Foundation
 */
class FCommento extends FDataBase {

    private static $class = "FCommento";
    private static $table = "commento";
    private static $values = "(:id, :testo, :valutazione, :data, :idAutore, :idOpera)";

    public function __construct() {}

    public static function bind($stmt, ECommento $commento) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':testo', $commento->getTesto(), PDO::PARAM_STR);
        $stmt->bindValue(':valutazione', $commento->getValutazione(), PDO::PARAM_INT);
        $stmt->bindValue(':data', $commento->getData()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
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
        $commento = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);

        if (($result != null) && ($rows_number == 1)) {
            // Carichiamo l'oggetto Utente e l'oggetto Opera tramite le loro classi Foundation
            $autore = FUtente::loadByField("id", $result["idAutore"]);
            $opera = FOpera::loadByField("id", $result["idOpera"]);

            $commento = new ECommento(
                $result['id'], $result['testo'], $result['valutazione'], 
                new DateTimeImmutable($result['data']), $autore, $opera
            );
        } 
        else if (($result != null) && ($rows_number > 1)) {
            $commento = array();
            for ($i = 0; $i < count($result); $i++) {
                $autore = FUtente::loadByField("id", $result[$i]["idAutore"]);
                $opera = FOpera::loadByField("id", $result[$i]["idOpera"]);

                $istanza = new ECommento(
                    $result[$i]['id'], $result[$i]['testo'], $result[$i]['valutazione'], 
                    new DateTimeImmutable($result[$i]['data']), $autore, $opera
                );
                $commento[] = $istanza;
            }
        }
        return $commento;
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