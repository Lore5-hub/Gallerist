<?php

/**
 * La classe FSegnalazione fornisce query per gli oggetti ESegnalazione
 * @package Foundation
 */
class FSegnalazione extends FDataBase {

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
        $segnalazione = null;
        $db = FDatabase::getInstance();
        $result = $db->loadDB(static::getClass(), $field, $id);
        $rows_number = $db->interestedRows(static::getClass(), $field, $id);

        if (($result != null) && ($rows_number == 1)) {
            // Ricostruiamo la classe dello stato corretta (State Pattern) leggendola dal DB
            $classeStato = $result['stato']; // es. "EStatoNuova"
            $statoOggetto = new $classeStato();

            $segnalazione = new ESegnalazione(
                $result['id'], $result['tipoOggetto'], $result['motivo'], 
                $result['nota'], $statoOggetto, $result['data']
            );
        } 
        else if (($result != null) && ($rows_number > 1)) {
            $segnalazione = array();
            for ($i = 0; $i < count($result); $i++) {
                $classeStato = $result[$i]['stato'];
                $statoOggetto = new $classeStato();

                $istanza = new ESegnalazione(
                    $result[$i]['id'], $result[$i]['tipoOggetto'], $result[$i]['motivo'], 
                    $result[$i]['nota'], $statoOggetto, $result[$i]['data']
                );
                $segnalazione[] = $istanza;
            }
        }
        return $segnalazione;
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