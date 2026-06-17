<?php

/**
 * La classe FSegnalazione fornisce query per gli oggetti ESegnalazione
 * @package Foundation
 */
class FSegnalazione {

    private static $class = "FSegnalazione";
    private static $table = "segnalazione";
    private static $values = "(:id, :tipoOggetto, :motivo, :nota, :stato, :data)";

    public function __construct() {}

    public static function bind($stmt, ESegnalazione $segnalazione) {
        $stmt->bindValue(':id', NULL, PDO::PARAM_INT);
        $stmt->bindValue(':tipoOggetto', $segnalazione->getTipoOggetto(), PDO::PARAM_STR);
        $stmt->bindValue(':motivo', $segnalazione->getMotivo(), PDO::PARAM_STR);
        $stmt->bindValue(':nota', $segnalazione->getNotaOpzionale(), PDO::PARAM_STR);
        
        // Salviamo sul database il nome testuale della classe dello Stato (State Pattern)
        $stmt->bindValue(':stato', get_class($segnalazione->getStato()), PDO::PARAM_STR);
        $stmt->bindValue(':data', $segnalazione->getDataSegnalazione(), PDO::PARAM_STR);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(ESegnalazione $segnalazione) {
        $db = FDatabase::getInstance();
        return $db->storeDB(static::getClass(), $segnalazione);
    }

public static function loadByField($field, $id) {
    $db     = FDatabase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!is_array($result[0])) {
        // Singolo record
        $classeStato  = $result['stato']; // es. "EStatoNuova"
        $statoOggetto = new $classeStato();
        return new ESegnalazione(
            $result['id'], $result['tipoOggetto'], $result['motivo'],
            $result['nota'], $statoOggetto, $result['data']
        );
    }

    // Record multipli
    $segnalazioni = [];
    foreach ($result as $row) {
        $classeStato  = $row['stato'];
        $statoOggetto = new $classeStato();
        $segnalazioni[] = new ESegnalazione(
            $row['id'], $row['tipoOggetto'], $row['motivo'],
            $row['nota'], $statoOggetto, $row['data']
        );
    }
    return $segnalazioni;
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