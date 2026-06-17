<?php

/**
 * La classe FOpera fornisce query per gli oggetti EOpera (UC5)
 * @package Foundation
 */
class FOpera {

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
    $db     = FDatabase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!is_array($result[0])) {
        // Singolo record
        $artista = FUtente::loadByField("id", $result["idArtista"]);
        $opera = new EOpera(
            $result['titolo'], $result['anno'], $result['tecnica'],
            $result['larghezza'], $result['altezza'], $result['profondita'],
            $result['unitaMisura'], $result['descrizione'], $result['categoria'],
            $result['prezzo'], $result['stato'], $artista
        );
        $opera->setId($result['id']);
        return $opera;
    }

    // Record multipli
    $opere = [];
    foreach ($result as $row) {
        $artista = FUtente::loadByField("id", $row["idArtista"]);
        $istanza = new EOpera(
            $row['titolo'], $row['anno'], $row['tecnica'],
            $row['larghezza'], $row['altezza'], $row['profondita'],
            $row['unitaMisura'], $row['descrizione'], $row['categoria'],
            $row['prezzo'], $row['stato'], $artista
        );
        $istanza->setId($row['id']);
        $opere[] = $istanza;
    }
    return $opere;
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