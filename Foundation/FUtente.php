<?php


/**
 * Classe Foundation per la gestione della persistenza dell'entità Utente.
 * Segue il pattern degli altri Foundation del progetto (FOpera, FOrdine, ecc.)
 * delegando le operazioni CRUD generiche a FDataBase.
 * @package Foundation
 */
class FUtente {

    private static string $class  = "FUtente";
    private static string $table  = "utente";
    private static string $values = "(:id, :nome, :cognome, :data_nascita, :indirizzo, :nickname, :telefono, :email, :password, :immagine_profilo, :stato_account, :ruolo, :data_registrazione)";

    public function __construct() {}

    /**
     * Lega i valori dell'entità EUtente ai parametri dello statement PDO.
     * Chiamato internamente da FDataBase::storeDB().
     *
     * FIX: :id ora passa il valore reale dell'entità se != 0,
     * oppure null (AUTO_INCREMENT) se l'id non è ancora assegnato.
     */
    public static function bind($stmt, EUtente $utente): void {
        // FIX: id non più hardcoded a null — supporta sia AUTO_INCREMENT (id=0)
        // sia un id esplicito (es. ripristino dati).
        $id = $utente->getId();
        $stmt->bindValue(':id',              $id === 0 ? null : $id,        $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindValue(':nome',            $utente->getNome(),             PDO::PARAM_STR);
        $stmt->bindValue(':cognome',         $utente->getCognome(),          PDO::PARAM_STR);
        $stmt->bindValue(':data_nascita',    $utente->getDataDiNascita()->format('Y-m-d'),    PDO::PARAM_STR);
        $stmt->bindValue(':indirizzo',       $utente->getIndirizzo(),        PDO::PARAM_STR);
        $stmt->bindValue(':nickname',        $utente->getNickname(),         PDO::PARAM_STR);
        $stmt->bindValue(':telefono',        $utente->getTelefono(),         PDO::PARAM_STR);
        $stmt->bindValue(':email',           $utente->getEmail(),            PDO::PARAM_STR);
         $stmt->bindValue(':ruolo',           $utente->getRuolo(),            PDO::PARAM_STR);
        $stmt->bindValue(':password',        $utente->getPassword(),         PDO::PARAM_STR); // Arriva già hashata dal Control
        $img = $utente->getImmagineProfilo();
        $stmt->bindValue(':immagine_profilo', $img, $img === null ? PDO::PARAM_NULL : PDO::PARAM_STR); // gestisce il nullable
        $stmt->bindValue(':stato_account',   $utente->getStatoAccount(),     PDO::PARAM_STR);
        $stmt->bindValue(':data_registrazione', $utente->getDataRegistrazione()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
    }

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    /**
     * Verifica se un'email è già registrata nel database.
     */
    public static function esisteEmail(string $email): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, 'email', $email) !== null);
    }

    /**
     * Salva un nuovo Utente nel database.
     * @return string|null L'ID generato dal DB, oppure null in caso di errore.
     */
    public static function store(EUtente $utente): ?string {
        $db = FDataBase::getInstance();
        return $db->storeDB(static::$class, $utente);
    }

    /**
     * Carica uno o più Utenti dal database in base a un campo e valore.
     * @return EUtente|EUtente[]|null
     *
     * FIX: il controllo per discriminare record singolo da multipli
     * era fragile ($result[0] nel caso singolo è il valore della prima
     * colonna, non un sotto-array). Ora si usa isset() + is_array()
     * sul primo elemento in modo esplicito e sicuro.
     */
    public static function loadByField(string $field, mixed $id): mixed {
        $db     = FDataBase::getInstance();
        $result = $db->loadDB(static::$class, $field, $id);

        if ($result === null) {
            return null;
        }

        // FIX: record singolo → array associativo piatto (es. ['id'=>1,'nome'=>'Mario',...])
        // Il primo elemento NON è un sotto-array, quindi !isset o !is_array lo identifica.
        if (!isset($result[0]) || !is_array($result[0])) {
            return self::creaEntitaDaArray($result);
        }

        // Record multipli → array di array associativi
        $utenti = [];
        foreach ($result as $row) {
            $utenti[] = self::creaEntitaDaArray($row);
        }
        return $utenti;
    }

    /**
     * Verifica l'esistenza di un record tramite un campo arbitrario.
     */
    public static function exist(string $field, mixed $id): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $id) !== null);
    }

    /**
     * Aggiorna un singolo attributo dell'utente nel database.
     */
    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    /**
     * Elimina un utente dal database tramite un campo e valore.
     */
    public static function delete(string $field, mixed $id): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $id);
    }

    // ---------------------------------------------------------------------------
    // Metodo privato di supporto
    // ---------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di EUtente a partire da un array associativo del DB.
     */
    private static function creaEntitaDaArray(array $row): EUtente {
    return new EUtente(
        (int) $row['id'],
        $row['nome'],
        $row['cognome'],
        new DateTimeImmutable($row['data_nascita']),
        $row['indirizzo'],
        $row['nickname'],
        $row['telefono'],
        $row['email'],
        $row['password'],
        $row['immagine_profilo'] ?? null,
        $row['stato_account']    ?? EUtente::STATO_ATTIVO,
        $row['ruolo']            ?? EUtente::RUOLO_USER,
        isset($row['data_registrazione']) ? new DateTimeImmutable($row['data_registrazione']) : new DateTimeImmutable() // ← aggiunto
    );
}
    /**
 * Incontra l'utente nel DB tramite email e ne verifica la password.
 * @param string $email
 * @param string $password Password in chiaro inserita nel form
 * @return EUtente|null L'oggetto Utente se corretto, altrimenti null
 */
public static function verificaCredenziali(string $email, string $password): ?EUtente {
    // 1. Cerchiamo se esiste un utente con questa email
    $utente = self::loadByField('email', $email);

    // Se loadByField dovesse restituire un array (es. più risultati), prendiamo il primo
    if (is_array($utente)) {
        $utente = !empty($utente) ? $utente[0] : null;
    }

    // 2. Se l'utente esiste, verifichiamo la password
    if ($utente instanceof EUtente) {
        // password_verify confronta la stringa in chiaro con l'hash memorizzato nel DB
        if (password_verify($password, $utente->getPassword())) {
            return $utente;
        }
    }

    // Credenziali errate o utente inesistente
    return null;
}
/**
 * Scorciatoia per caricare un utente direttamente dal suo ID.
 */
public static function load(int $id): ?EUtente {
    $utente = self::loadByField('id', $id);
    return ($utente instanceof EUtente) ? $utente : null;
}
}
?>