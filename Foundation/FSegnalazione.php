<?php

/**
 * La classe FSegnalazione fornisce query per gli oggetti ESegnalazione
 * @package Foundation
 */
class FSegnalazione {

    private static $class = "FSegnalazione";
    private static $table = "segnalazione";
    private static $values = "(:id, :motivo, :descrizione, :dataSegnalazione, :stato, :tipoOggetto, :idOggettoSegnalato, :idSegnalatore)";


    public function __construct() {}

    public static function bind($stmt, ESegnalazione $segnalazione) {
        $stmt->bindValue(':id',                NULL,                                        PDO::PARAM_INT);
    $stmt->bindValue(':motivo',            $segnalazione->getMotivo(),                  PDO::PARAM_STR);
    $stmt->bindValue(':descrizione',       $segnalazione->getNotaOpzionale(),           PDO::PARAM_STR);
    $stmt->bindValue(':dataSegnalazione', $segnalazione->getDataSegnalazione()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    $stmt->bindValue(':stato', $segnalazione->getStato()->getNomeStato(), PDO::PARAM_STR);
    $stmt->bindValue(':tipoOggetto',       $segnalazione->getTipoTarget(),              PDO::PARAM_STR);
    $stmt->bindValue(':idOggettoSegnalato',$segnalazione->getIdTarget(),                PDO::PARAM_INT);
    $stmt->bindValue(':idSegnalatore',     $segnalazione->getIdSegnalatore(),           PDO::PARAM_INT);
    }

    public static function getClass() { return static::$class; }
    public static function getTable() { return static::$table; }
    public static function getValues() { return static::$values; }

    public static function store(ESegnalazione $segnalazione) {
        $db = FDataBase::getInstance();
        return $db->storeDB(static::getClass(), $segnalazione);
    }

public static function loadByField($field, $id) {
    $db     = FDataBase::getInstance();
    $result = $db->loadDB(static::getClass(), $field, $id);

    if ($result === null) {
        return null;
    }

    if (!isset($result[0]) || !is_array($result[0])) {
        // Singolo record
        $statoOggetto = match($result['stato']) {
            'Aperta'     => new EStatoNuova(),
            'Archiviata' => new EStatoArchiviata(),
            'Risolta'    => new EStatoRisolta(),
            default      => new EStatoNuova(),
        };
        $seg = new ESegnalazione(
    (int) $result['id'],
    $result['motivo'],
    $result['descrizione'] ?? '',
    new DateTimeImmutable($result['dataSegnalazione']),
    $result['tipoOggetto'],
    (int) $result['idOggettoSegnalato'],
    (int) $result['idSegnalatore']
);
$seg->setStato($statoOggetto); 
return $seg;
    }

    // Record multipli
    $segnalazioni = [];
    foreach ($result as $row) {
        $statoOggetto = match($row['stato']) {
            'Aperta'     => new EStatoNuova(),
            'Archiviata' => new EStatoArchiviata(),
            'Risolta'    => new EStatoRisolta(),
            default      => new EStatoNuova(),
        };
        $istanza = new ESegnalazione(
    (int) $row['id'],
    $row['motivo'],
    $row['descrizione'] ?? '',
    new DateTimeImmutable($row['dataSegnalazione']),
    $row['tipoOggetto'],
    (int) $row['idOggettoSegnalato'],
    (int) $row['idSegnalatore']
);
$istanza->setStato($statoOggetto);
$segnalazioni[] = $istanza;  
}  
return $segnalazioni;
}

    public static function exist($field, $id) {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::getClass(), $field, $id) != null);
    }

    public static function update($field, $newvalue, $pk, $id) {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::getClass(), $field, $newvalue, $pk, $id);
    }

    public static function delete($field, $id) {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::getClass(), $field, $id);
    }
}