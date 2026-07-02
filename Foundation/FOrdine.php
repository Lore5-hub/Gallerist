<?php
require_once __DIR__ . '/FDataBase.php';
require_once __DIR__ . '/FOpera.php';
require_once __DIR__ . '/FUtente.php';
require_once __DIR__ . '/../Entity/EOrdine.php';

/**
 * La classe FOrdine fornisce query per gli oggetti EOrdine (UC6)
 * @package Foundation
 */
class FOrdine {

    private static $class = "FOrdine";
    private static $table = "ordine";
    private static $values = "(:id, :data, :idUtente, :idOpera)";

    public function __construct() {}

    public static function bind($stmt, EOrdine $ordine) {
    $stmt->bindValue(':id',       NULL,                                           PDO::PARAM_INT);
    $stmt->bindValue(':data',     $ordine->getDataOrdine()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->bindValue(':idUtente', $ordine->getAcquirente()->getId(),              PDO::PARAM_INT);
    $stmt->bindValue(':idOpera',  $ordine->getOpera()->getId(),                   PDO::PARAM_INT);
}

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(EOrdine $ordine) {
        $db = FDatabase::getInstance();
        return $db->storeDB(static::getClass(), $ordine);
    }

public static function loadByField($field, $id) {
    $db     = FDatabase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!is_array($result[0])) {
        // Singolo record
        $ope = FOpera::loadByField("id", $result["idOpera"]);
        $acq = FUtente::loadByField("id", $result["idAcquirente"]);
        $art = FUtente::loadByField("id", $result["idArtista"]);
        $ordine = new EOrdine($result['dataOrdine'], $result['prezzoVendita'], $ope, $acq, $art);
        $ordine->setId($result['id']);
        return $ordine;
    }

    // Record multipli
    $ordini = [];
    foreach ($result as $row) {
        $ope = FOpera::loadByField("id", $row["idOpera"]);
        $acq = FUtente::loadByField("id", $row["idAcquirente"]);
        $art = FUtente::loadByField("id", $row["idArtista"]);
        $istanza = new EOrdine($row['dataOrdine'], $row['prezzoVendita'], $ope, $acq, $art);
        $istanza->setId($row['id']);
        $ordini[] = $istanza;
    }
    return $ordini;
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
            
            $ordine = new EOrdine(new DateTimeImmutable($result['dataOrdine']), $result['prezzoVendita'], $ope, $acq, $art);
            $ordine->setId($result['id']);
        } 
        else {
            if (($result != null) && ($rows_number > 1)) {
                $ordine = array();
                for ($i = 0; $i < count($result); $i++) {
                    $ope = FOpera::loadByField("id", $result[$i]["idOpera"]);
                    $acq = FUtente::loadByField("id", $result[$i]["idAcquirente"]);
                    $art = FUtente::loadByField("id", $result[$i]["idArtista"]);
                    
                    $istanza = new EOrdine(new DateTimeImmutable($result[$i]['dataOrdine']), $result[$i]['prezzoVendita'], $ope, $acq, $art);
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