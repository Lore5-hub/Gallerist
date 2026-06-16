<?php

/**
 * La classe FOrdine fornisce query per gli oggetti EOrdine (UC6)
 * @package Foundation
 */
class FOrdine extends FDataBase {

    private static $class = "FOrdine";
    private static $table = "ordine";
    private static $values = "(:id, :dataOrdine, :prezzoVendita, :idOpera, :idAcquirente, :idArtista)";

    public function __construct() {}

    public static function bind($stmt, EOrdine $ordine) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':dataOrdine', $ordine->getDataOrdine(), PDO::PARAM_STR); // Stringa Y-m-d
        $stmt->bindValue(':prezzoVendita', $ordine->getPrezzoVendita(), PDO::PARAM_STR);
        $stmt->bindValue(':idOpera', $ordine->getOpera()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':idAcquirente', $ordine->getAcquirente()->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':idArtista', $ordine->getArtista()->getId(), PDO::PARAM_INT);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(EOrdine $ordine) {
        $db = FDatabase::getInstance();
        return $db->storeDB(static::getClass(), $ordine);
    }

    public static function loadByField($field, $id) {
        $ordine = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);

        if (($result != null) && ($rows_number == 1)) {
            $ope = FOpera::loadByField("id", $result["idOpera"]);
            $acq = FUtente::loadByField("id", $result["idAcquirente"]);
            $art = FUtente::loadByField("id", $result["idArtista"]);
            
            $ordine = new EOrdine($result['dataOrdine'], $result['prezzoVendita'], $ope, $acq, $art);
            $ordine->setId($result['id']);
        } 
        else {
            if (($result != null) && ($rows_number > 1)) {
                $ordine = array();
                for ($i = 0; $i < count($result); $i++) {
                    $ope = FOpera::loadByField("id", $result[$i]["idOpera"]);
                    $acq = FUtente::loadByField("id", $result[$i]["idAcquirente"]);
                    $art = FUtente::loadByField("id", $result[$i]["idArtista"]);
                    
                    $istanza = new EOrdine($result[$i]['dataOrdine'], $result[$i]['prezzoVendita'], $ope, $acq, $art);
                    $istanza->setId($result[$i]['id']);
                    $ordine[] = $istanza;
                }
            }
        }
        return $ordine;
    }

    /**
     * Metodo personalizzato per l'UC6 modellato sulla logica di 'loadByForm' del file di esempio.
     * Permette all'artista di filtrare lo storico in base a un intervallo di date.
     */
    public static function loadVenditeByPeriodo($idArtista, $dataInizio, $dataFine) {
        $ordine = null;
        $db = FDatabase::getInstance();
        
        // Supponiamo che FDatabase esponga un metodo per le query personalizzate sui periodi
        list($result, $rows_number) = $db->loadOrdiniFiltrati($idArtista, $dataInizio, $dataFine);

        if (($result != null) && ($rows_number == 1)) {
            $ope = FOpera::loadByField("id", $result["idOpera"]);
            $acq = FUtente::loadByField("id", $result["idAcquirente"]);
            $art = FUtente::loadByField("id", $result["idArtista"]);
            
            $ordine = new EOrdine($result['dataOrdine'], $result['prezzoVendita'], $ope, $acq, $art);
            $ordine->setId($result['id']);
        } 
        else {
            if (($result != null) && ($rows_number > 1)) {
                $ordine = array();
                for ($i = 0; $i < count($result); $i++) {
                    $ope = FOpera::loadByField("id", $result[$i]["idOpera"]);
                    $acq = FUtente::loadByField("id", $result[$i]["idAcquirente"]);
                    $art = FUtente::loadByField("id", $result[$i]["idArtista"]);
                    
                    $istanza = new EOrdine($result[$i]['dataOrdine'], $result[$i]['prezzoVendita'], $ope, $acq, $art);
                    $istanza->setId($result[$i]['id']);
                    $ordine[] = $istanza;
                }
            }
        }
        return $ordine;
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