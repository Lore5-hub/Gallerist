<?php

/**
 * La classe FOpera fornisce query per gli oggetti EOpera (UC5)
 * @package Foundation
 */
class FOpera extends FDataBase {

    private static $class = "FOpera";
    private static $table = "opera";
    private static $values = "(:id, :titolo, :anno, :tecnica, :larghezza, :altezza, :profondita, :unitaMisura, :descrizione, :categoria, :prezzo, :stato, :idArtista)";

    public function __construct() {}

    public static function bind($stmt, EOpera $opera) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':titolo', $opera->getTitolo(), PDO::PARAM_STR);
        $stmt->bindValue(':anno', $opera->getAnno(), PDO::PARAM_INT);
        $stmt->bindValue(':tecnica', $opera->getTecnica(), PDO::PARAM_STR);
        $stmt->bindValue(':larghezza', $opera->getLarghezza(), PDO::PARAM_STR);
        $stmt->bindValue(':altezza', $opera->getAltezza(), PDO::PARAM_STR);
        $stmt->bindValue(':profondita', $opera->getProfondita(), PDO::PARAM_STR);
        $stmt->bindValue(':unitaMisura', $opera->getUnitaMisura(), PDO::PARAM_STR);
        $stmt->bindValue(':descrizione', $opera->getDescrizione(), PDO::PARAM_STR);
        $stmt->bindValue(':categoria', $opera->getCategoria(), PDO::PARAM_STR);
        $stmt->bindValue(':prezzo', $opera->getPrezzo(), PDO::PARAM_STR);
        $stmt->bindValue(':stato', $opera->getStato(), PDO::PARAM_STR);
        $stmt->bindValue(':idArtista', $opera->getArtista()->getId(), PDO::PARAM_INT);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(EOpera $opera) {
        $db = FDatabase::getInstance();
        $artistaEsiste = FUtente::exist("id", $opera->getArtista()->getId());
        if ($artistaEsiste) {
            return $db->storeDB(static::getClass(), $opera);
        }
        return false;
    }

    public static function loadByField($field, $id) {
        $opera = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);

        if (($result != null) && ($rows_number == 1)) {
            $artista = FUtente::loadByField("id", $result["idArtista"]);
            $opera = new EOpera(
                $result['titolo'], $result['anno'], $result['tecnica'], 
                $result['larghezza'], $result['altezza'], $result['profondita'], 
                $result['unitaMisura'], $result['descrizione'], $result['categoria'], 
                $result['prezzo'], $result['stato'], $artista
            );
            $opera->setId($result['id']);
        } 
        else {
            if (($result != null) && ($rows_number > 1)) {
                $opera = array();
                for ($i = 0; $i < count($result); $i++) {
                    $artista = FUtente::loadByField("id", $result[$i]["idArtista"]);
                    $istanza = new EOpera(
                        $result[$i]['titolo'], $result[$i]['anno'], $result[$i]['tecnica'], 
                        $result[$i]['larghezza'], $result[$i]['altezza'], $result[$i]['profondita'], 
                        $result[$i]['unitaMisura'], $result[$i]['descrizione'], $result[$i]['categoria'], 
                        $result[$i]['prezzo'], $result[$i]['stato'], $artista
                    );
                    $istanza->setId($result[$i]['id']);
                    $opera[] = $istanza;
                }
            }
        }
        return $opera;
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
?>