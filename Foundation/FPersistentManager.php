<?php
// Foundation/FPersistentManager.php

class FPersistentManager {

    /**
     * Salva un oggetto Entity sul DB.
     */
    public static function store(object $obj): ?string {
        // Usa l'oggetto per ricavare la classe F
        $Fclass = self::getFClassFromObj($obj);
        return $Fclass::store($obj);
    }

    /**
     * Carica uno o più oggetti Entity dal DB.
     * Ora accetta il nome dell'Entity (es. 'EUtente') invece della Foundation!
     */
    public static function load(string $Eclass, string $field, mixed $val): mixed {
        $Fclass = self::getFClassFromName($Eclass);
        return $Fclass::loadByField($field, $val);
    }

    /**
     * Verifica l'esistenza di un record nel DB.
     */
    public static function exist(string $Eclass, string $field, mixed $val): bool {
        $Fclass = self::getFClassFromName($Eclass);
        return $Fclass::exist($field, $val);
    }

    /**
     * Aggiorna un campo di un record nel DB.
     */
    public static function update(string $Eclass, string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $Fclass = self::getFClassFromName($Eclass);
        return $Fclass::update($field, $newvalue, $pk, $id);
    }

    /**
     * Elimina un record dal DB.
     */
    public static function delete(string $Eclass, string $field, mixed $val): ?bool {
        $Fclass = self::getFClassFromName($Eclass);
        return $Fclass::delete($field, $val);
    }

    // ---------------------------------------------------------------------------
    // Helper (privati)

    /**
     * Ricava il nome della classe Foundation da un oggetto Entity.
     * Esempio: oggetto EUtente -> stringa 'FUtente'
     */
    private static function getFClassFromObj(object $obj): string {
        $nomeClasse = get_class($obj);
        return self::getFClassFromName($nomeClasse);
    }

    /**
     * Ricava il nome della classe Foundation dal nome della classe Entity sostituendo in modo sicuro solo la prima lettera.
     * Esempio: 'EElemento' -> 'FElemento'
     */
    private static function getFClassFromName(string $Eclass): string {
        return 'F' . substr($Eclass, 1);
    }
}
?>