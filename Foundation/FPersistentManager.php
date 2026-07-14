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
    public static function getArtistiInAttesa(): array {
    $risultato = FArtista::loadByField('stato_validazione', 'IN_ATTESA', 'a');
    if ($risultato === null)              return [];
    if ($risultato instanceof EArtista)   return [$risultato];
    return $risultato;
}

public static function getArtistiAttivi(): array {
    $risultato = FArtista::loadByField('stato_validazione', 'APPROVATO', 'a');
    if ($risultato === null)              return [];
    if ($risultato instanceof EArtista)   return [$risultato];
    return $risultato;
}

public static function getUtentiStandard(): array {
    $risultato = FUtente::loadByField('ruolo', 'Utente registrato');
    if ($risultato === null)             return [];
    if ($risultato instanceof EUtente)   return [$risultato];
    return $risultato;
}
public static function getSegnalazioniAperte(): array {
    $risultato = FSegnalazione::loadByField('stato', 'Aperta');
    if ($risultato === null)                    return [];
    if ($risultato instanceof ESegnalazione)    return [$risultato];
    return $risultato;
}
public static function getProvvedimentiAttivi(): array {
    $db = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT p.*, u.nickname, u.email 
         FROM provvedimento p 
         INNER JOIN utente u ON u.id = p.idUtenteSanzionato
         ORDER BY p.dataInizio DESC",
        []
    );
    return $result ?? [];
}

public static function getCategorieTutte(): array {
    $db = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT c.nome, c.descrizione, COUNT(o.id) as num_opere
         FROM categoria c
         LEFT JOIN opera o ON o.categoria = c.nome
         GROUP BY c.nome, c.descrizione
         ORDER BY c.nome ASC",
        []
    );
    return $result ?? [];
}

public static function getSegnalazioniTutte(): array {
    $db = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT * FROM segnalazione ORDER BY dataSegnalazione DESC",
        []
    );
    if (empty($result)) return [];
    // Costruisci oggetti ESegnalazione
    $segnalazioni = [];
    foreach ($result as $row) {
        $statoOggetto = match($row['stato']) {
            'Aperta'     => new EStatoNuova(),
            'Archiviata' => new EStatoArchiviata(),
            'Risolta'    => new EStatoRisolta(''),
            default      => new EStatoNuova(),
        };
        $seg = new ESegnalazione(
            (int) $row['id'],
            $row['motivo'],
            $row['descrizione'] ?? '',
            new DateTimeImmutable($row['dataSegnalazione']),
            $row['tipoOggetto'],
            (int) $row['idOggettoSegnalato'],
            (int) $row['idSegnalatore']
        );
        $seg->setStato($statoOggetto);
        $segnalazioni[] = $seg;
    }
    return $segnalazioni;
}

public static function contaAcquistiUtente(int $idUtente): int {
    $db = FDataBase::getInstance();
    $result = $db->queryDB(
        "SELECT COUNT(*) as totale FROM ordine WHERE idUtente = :id",
        [':id' => $idUtente]
    );
    return $result ? (int)$result[0]['totale'] : 0;
}
}
?>