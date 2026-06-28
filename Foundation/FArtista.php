<?php
require_once __DIR__ . '/FDataBase.php';
require_once __DIR__ . '/FUtente.php';
require_once __DIR__ . '/../Entity/EArtista.php';

/**
 * Classe Foundation per la persistenza dell'entità Artista.
 * EArtista è una specializzazione di EUtente: il suo store richiede
 * una transazione che coinvolge due tabelle (UTENTE + ARTISTA).
 * @package Foundation
 */
class FArtista {

    private static string $class  = "FArtista";
    private static string $table  = "artista";
    private static string $values = "(:id_utente, :biografia, :stile_artistico, :carta_identita, :stato_validazione)";

    public function __construct() {}

    /**
     * Lega i valori specifici di EArtista ai parametri dello statement PDO.
     * Usato da FDataBase::storeDB() per la sola tabella ARTISTA.
     */
    public static function bind($stmt, EArtista $artista): void {
        $stmt->bindValue(':id_utente',      $artista->getId(),            PDO::PARAM_STR);
        $stmt->bindValue(':biografia',         $artista->getBiografia(),        PDO::PARAM_STR);
        $stmt->bindValue(':stile_artistico',   $artista->getStileArtistico(),   PDO::PARAM_STR);
        $stmt->bindValue(':carta_identita',    $artista->getCartaIdentita(),    PDO::PARAM_STR);
        $stmt->bindValue(':stato_validazione', $artista->getStatoValidazione(), PDO::PARAM_STR);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    /**
     * Salva un nuovo Artista nel database.
     *
     * FIX: la versione precedente apriva una connessione PDO diretta,
     * bypassando FDataBase e duplicando le credenziali. Ora si usa
     * FDataBase::getInstance() come tutte le altre Foundation.
     *
     * La transazione a due tabelle (UTENTE + ARTISTA) viene gestita
     * in sequenza: prima FUtente::store() inserisce la riga in UTENTE,
     * poi FDataBase::storeDB() inserisce la riga in ARTISTA.
     * Se il secondo inserimento fallisce, il record UTENTE rimane orfano:
     * per un progetto accademico la soluzione accettabile è affidarsi al
     * vincolo di FK con ON DELETE CASCADE sul DB, che pulisce UTENTE
     * automaticamente se ARTISTA non viene inserito.
     *
     * @return string|null L'ID generato dal DB per la riga UTENTE, oppure null in caso di errore.
     */
    public static function store(EArtista $artista): ?string {
        // 1. Inserimento in UTENTE tramite FUtente (rispetta il pattern)
        $idGenerato = FUtente::store($artista);

        if ($idGenerato === null) {
            error_log("FArtista::store - Inserimento in UTENTE fallito.");
            return null;
        }
        $artista->setId((int)$idGenerato);
        // 2. Inserimento in ARTISTA (campi specifici della sottoclasse)
        $db     = FDataBase::getInstance();
        $result = $db->storeDB(static::$class, $artista);

        if ($result === null) {
            error_log("FArtista::store - Inserimento in ARTISTA fallito per email: " . $artista->getEmail());
            // Il record UTENTE è già stato inserito: il cleanup dipende dal vincolo FK con CASCADE sul DB.
            return null;
        }

        return $idGenerato;
    }

    /**
     * Carica uno o più Artisti dal database effettuando una JOIN tra ARTISTA e UTENTE.
     * @return EArtista|EArtista[]|null
     *
     * @param string $field  Il nome della colonna su cui filtrare (es. 'id', 'email', 'stato_validazione')
     * @param mixed  $id     Il valore da cercare
     * @param string $alias  Alias della tabella a cui appartiene $field:
     *                       'u' per UTENTE (default), 'a' per ARTISTA.
     *                       Necessario per evitare ambiguità su colonne omonime tra le due tabelle.
     *
     * Esempi d'uso:
     *   FArtista::loadByField('id', 5)                               // campo di UTENTE (default)
     *   FArtista::loadByField('email', 'x@y.it')                    // campo di UTENTE (default)
     *   FArtista::loadByField('stato_validazione', 'IN_ATTESA', 'a') // campo di ARTISTA
     */
    public static function loadByField(string $field, mixed $id, string $alias = 'u'): mixed {
       $query = "SELECT u.*, 
                 a.biografia, 
                 a.stileArtistico  AS stile_artistico,
                 a.carta_identita, 
                 a.stato_validazione
          FROM " . FUtente::getTable() . " u
          INNER JOIN " . static::$table . " a ON a.idUtente = u.id
          WHERE " . $alias . "." . $field . " = :id";
          

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, [':id' => $id]);

        if ($result === null) {
            return null;
        }

        // fetchAll() garantisce sempre array di array → count() è sicuro
        if (count($result) === 1) {
            return self::creaEntitaDaArray($result[0]);
        }

        $artisti = [];
        foreach ($result as $row) {
            $artisti[] = self::creaEntitaDaArray($row);
        }
        return $artisti;
    }

    /**
     * Verifica l'esistenza di un record tramite un campo arbitrario.
     */
    public static function exist(string $field, mixed $id): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $id) !== null);
    }

    /**
     * Aggiorna un singolo attributo dell'artista nel database.
     * Utile per cambiare stato_validazione da CGestionePiattaforma.
     */
    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    /**
     * Elimina un artista dal database tramite un campo e valore.
     */
    public static function delete(string $field, mixed $id): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $id);
    }

    // ---------------------------------------------------------------------------
    // Metodo privato di supporto
    // ---------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di EArtista a partire da un array associativo del DB.
     * Assume che la query abbia fatto JOIN tra UTENTE e ARTISTA (o che il result
     * contenga già tutti i campi necessari).
     *
     * FIX: aggiunto stato_account mancante, che EArtista eredita da EUtente.
     */
    private static function creaEntitaDaArray(array $row): EArtista { 
        return new EArtista(
            (int) $row['id'],
            $row['nome'],
            $row['cognome'],
            new DateTimeImmutable($row['data_nascita']),
            $row['indirizzo'],
            $row['nickname'],
            $row['telefono'],
            $row['email'],
            $row['password'],
            $row['immagine_profilo']  ?? null,
           // $row['stato_account']     ?? EUtente::STATO_ATTIVO,  // FIX: campo mancante
            $row['biografia'],
            $row['stile_artistico'],
            $row['carta_identita'],
            $row['stato_validazione'] ?? EArtista::STATO_IN_ATTESA
        );
    }
}
?>