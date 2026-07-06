<?php
require_once __DIR__ . '/FDataBase.php';
require_once __DIR__ . '/FCategoria.php';
require_once __DIR__ . '/../Entity/EOpera.php';
require_once __DIR__ . '/../Entity/EArtista.php';
require_once __DIR__ . '/../Entity/EUtente.php';

/**
 * Classe Foundation per la gestione della persistenza dell'entità Opera.
 * @package Foundation
 */
class FOpera {

    private static string $class  = "FOpera";
    private static string $table  = "opera";
    private static string $values = "(:id, :titolo, :anno, :dimensioni, :descrizione, :prezzo, :statoOpera, :idArtista, :idCategoria, :idTecnica, :categoria, :tecnica, :stato, :larghezza, :altezza, :profondita, :unitaMisura)";

    public function __construct() {}

    /**
     * Lega i valori di EOpera ai parametri dello statement PDO.
     * Chiamato internamente da FDataBase::storeDB().
     *
     * FIX: :id non più hardcoded a NULL — supporta AUTO_INCREMENT (id=0)
     * e id esplicito (es. ripristino dati), coerente con FUtente e FArtista.
     */
    public static function bind($stmt, EOpera $opera): void {
    $id = $opera->getId();
    $stmt->bindValue(':id',          $id === 0 ? null : $id,                  $id === 0 ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindValue(':titolo',      $opera->getTitolo(),                      PDO::PARAM_STR);
    $stmt->bindValue(':anno',        $opera->getAnno(),                        PDO::PARAM_INT);
    $stmt->bindValue(':dimensioni',  $opera->getDimensioni(),                  PDO::PARAM_STR);
    $stmt->bindValue(':descrizione', $opera->getDescrizione(),                 PDO::PARAM_STR);
    $stmt->bindValue(':prezzo',      $opera->getPrezzo()->getValore(),         PDO::PARAM_STR);
    $stmt->bindValue(':statoOpera',  'In esposizione',                         PDO::PARAM_STR);
    $stmt->bindValue(':idArtista',   $opera->getArtista()->getId(),            PDO::PARAM_INT);
    $stmt->bindValue(':idCategoria', $opera->getIdCategoria(),                 PDO::PARAM_INT);
    $stmt->bindValue(':idTecnica',   $opera->getIdTecnica(),                   PDO::PARAM_INT);
    $stmt->bindValue(':categoria',   $opera->getCategoria()->getNome(),        PDO::PARAM_STR);
    $stmt->bindValue(':tecnica',     $opera->getTecnica()->getNome(),          PDO::PARAM_STR);
    $stmt->bindValue(':stato',       $opera->getStatoOpera()->getNomeStato(),  PDO::PARAM_STR);
    $stmt->bindValue(':larghezza',   $opera->getLarghezza(),                   PDO::PARAM_STR);
    $stmt->bindValue(':altezza',     $opera->getAltezza(),                     PDO::PARAM_STR);
    $stmt->bindValue(':profondita',  $opera->getProfondita(),                  PDO::PARAM_STR);
    $stmt->bindValue(':unitaMisura', $opera->getUnitaMisura(),                 PDO::PARAM_STR);
}

    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    /**
     * Salva una nuova EOpera nel database con salvataggio a cascata di immagini e tag.
     *
     * L'opera "possiede" le sue immagini e i suoi tag: è responsabilità di FOpera
     * salvarli dopo aver ottenuto l'ID dell'opera dal DB.
     * Questo approccio risolve il problema di FPersistentManager::store() che
     * accetta un solo parametro: il Manager chiama FOpera::store($opera) e
     * FOpera gestisce internamente il salvataggio degli oggetti annidati.
     *
     * Flusso:
     *  1. Verifica che l'artista esista
     *  2. Salva l'opera → ottiene $idOpera
     *  3. Per ogni EImmagine in $opera->getImmagini(): FImmagine::store($img, $idOpera)
     *  4. Per ogni ETag in $opera->getTag():           FTag::store($tag, $idOpera)
     *
     * Se il salvataggio dell'opera fallisce, immagini e tag non vengono toccate.
     * I fallimenti sui singoli asset (immagine/tag) sono loggati ma non bloccanti:
     * un'opera senza immagini o senza tag è comunque valida.
     *
     * @return string|null L'ID generato dal DB oppure null in caso di errore.
     */
    public static function store(EOpera $opera): ?string {
        $db = FDataBase::getInstance();

        // ✅ CORRETTO
if (!FArtista::exist('idUtente', $opera->getArtista()->getId()))  {
            error_log("FOpera::store - Artista non esistente per email: " . $opera->getArtista()->getEmail());
            return null;
        }

        // 1. Salvataggio dell'opera — il DB genera l'ID
        $idOpera = $db->storeDB(static::$class, $opera);
        if ($idOpera === null) {
            return null;
        }

        // 2. Salvataggio a cascata delle immagini (ordine preservato: la prima è la copertina)
        foreach ($opera->getImmagini() as $immagine) {
            $idImg = FImmagine::store($immagine, (int) $idOpera);
            if ($idImg === null) {
                error_log("FOpera::store - FImmagine::store fallita per opera $idOpera, file: " . $immagine->getUrlFile());
                // Non bloccante: l'opera è comunque salvata
            }
        }

        // 3. Salvataggio a cascata dei tag (deduplicazione gestita da FTag::store)
        foreach ($opera->getTag() as $tag) {
            $idTag = FTag::store($tag, (int) $idOpera);
            if ($idTag === null) {
                error_log("FOpera::store - FTag::store fallita per opera $idOpera, tag: " . $tag->getNomeTag());
                // Non bloccante: l'opera è comunque salvata
            }
        }

        return $idOpera;
    }

    /**
     * Carica una o più Opere dal database in base a un campo e valore.
     * Usa queryDB() con JOIN su UTENTE per evitare il problema N+1.
     *
     * FIX: la versione originale chiamava FUtente::loadByField() dentro il loop
     * (una query per ogni opera → problema N+1). Ora è una sola query con JOIN.
     * FIX: controllo singolo/multiplo robusto con isset() + is_array() rimosso,
     * ora fetchAll() via queryDB() garantisce sempre array di array.
     *
     * @return EOpera|EOpera[]|null
     */
    public static function loadByField(string $field, mixed $id): mixed {
        $query = "SELECT o.*,
                         u.nome     AS artista_nome,
                         u.cognome  AS artista_cognome,
                         u.email    AS artista_email,
                         u.nickname AS artista_nickname
                  FROM " . static::$table . " o
                  INNER JOIN UTENTE u ON o.idArtista = u.id
                  WHERE o." . $field . " = :id";

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, [':id' => $id]);

        if ($result === null) {
            return null;
        }

        if (count($result) === 1) {
            return self::creaOperaDaArray($result[0]);
        }

        $opere = [];
        foreach ($result as $row) {
            $opere[] = self::creaOperaDaArray($row);
        }
        return $opere;
    }

    /**
     * Carica tutte le EOpera appartenenti a una categoria tramite JOIN.
     *
     * Spostato da FCategoria a FOpera (principio SRP): questo metodo
     * restituisce EOpera, quindi è responsabilità di FOpera costruirli.
     *
     * La JOIN con CATEGORIA (non solo WHERE o.categoria = :nome) è
     * intenzionale: garantisce che vengano restituite solo opere con
     * categorie effettivamente esistenti nella tabella CATEGORIA,
     * agendo come guardia implicita sull'integrità referenziale.
     *
     * NOTA: EArtista viene costruito con i soli campi disponibili dalla JOIN.
     * Se nella view servissero anche biografia/stile_artistico, aggiungere
     * un ulteriore INNER JOIN con la tabella ARTISTA.
     *
     * @param string $nomeCategoria Il nome della categoria da cercare
     * @return EOpera[]|null Array di opere oppure null se nessuna trovata
     */
    public static function loadByCategoria(string $nomeCategoria): ?array {
        $query = "SELECT o.*,
                         u.nome     AS artista_nome,
                         u.cognome  AS artista_cognome,
                         u.email    AS artista_email,
                         u.nickname AS artista_nickname
                  FROM " . static::$table . " o
                  INNER JOIN " . FCategoria::getTable() . " c ON o.categoria = c.nome
                  INNER JOIN UTENTE u ON o.idArtista = u.id
                  WHERE c.nome = :nome";

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, [':nome' => $nomeCategoria]);

        if ($result === null) {
            return null;
        }

        $opere = [];
        foreach ($result as $row) {
            $opere[] = self::creaOperaDaArray($row);
        }
        return $opere;
    }

    /**
     * Verifica l'esistenza di un'opera tramite un campo arbitrario.
     */
    public static function exist(string $field, mixed $id): bool {
        $db = FDataBase::getInstance();
        return ($db->existDB(static::$class, $field, $id) !== null);
    }

    /**
     * Aggiorna un singolo attributo dell'opera nel database.
     */
    public static function update(string $field, mixed $newvalue, string $pk, mixed $id): bool {
        $db = FDataBase::getInstance();
        return $db->updateDB(static::$class, $field, $newvalue, $pk, $id);
    }

    /**
     * Elimina un'opera dal database tramite un campo e valore.
     */
    public static function delete(string $field, mixed $id): ?bool {
        $db = FDataBase::getInstance();
        return $db->deleteDB(static::$class, $field, $id);
    }

    /**
     * Carica le opere pubblicate più recentemente (per id DESC).
     * Usato da CCatalogo::esploraCatalogo() per la griglia iniziale del catalogo.
     *
     * @param int $limite Numero massimo di opere da restituire (default 20)
     * @return EOpera[]|null
     */
    public static function loadRecenti(int $limite = 20): ?array {
        $query = "SELECT o.*,
                         u.nome     AS artista_nome,
                         u.cognome  AS artista_cognome,
                         u.email    AS artista_email,
                         u.nickname AS artista_nickname
                  FROM " . static::$table . " o
                  INNER JOIN UTENTE u ON o.idArtista = u.id
                  WHERE o.stato IN ('pubblicata', 'in_vendita')
                  AND u.stato_account != 'Bannato'
                  ORDER BY o.id DESC
                  LIMIT " . (int) $limite;

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, []);

        if ($result === null) {
            return null;
        }

        $opere = [];
        foreach ($result as $row) {
            $opere[] = self::creaOperaDaArray($row);
        }
        return $opere;
    }

    /**
     * Carica tutte le opere di un artista esclusa una specifica (es. l'opera corrente).
     * Usato da CCatalogo::visualizzaDettagliOpera() per la sezione "Altre opere dell'artista".
     *
     * @param int $idArtista    L'id dell'artista di cui caricare le opere
     * @param int $idEscluso    L'id dell'opera da escludere dai risultati
     * @return EOpera[]|null
     */
    public static function loadByArtista(int $idArtista, int $idEscluso): ?array {
        $query = "SELECT o.*,
                 u.nome     AS artista_nome,
                 u.cognome  AS artista_cognome,
                 u.email    AS artista_email,
                 u.nickname AS artista_nickname
          FROM " . static::$table . " o
          INNER JOIN UTENTE u ON o.idArtista = u.id
          WHERE o.idArtista = :idArtista
            AND o.id        != :idEscluso
          ORDER BY o.id DESC";

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, [
            ':idArtista' => $idArtista,
            ':idEscluso' => $idEscluso,
        ]);

        if ($result === null) {
            return null;
        }

        $opere = [];
        foreach ($result as $row) {
            $opere[] = self::creaOperaDaArray($row);
        }
        return $opere;
    }

    /**
     * Esegue una ricerca filtrata sul catalogo in base a parola chiave,
     * categoria e criterio di ordinamento.
     *
     * Usato da CCatalogo::filtraCatalogo().
     * Tutti i parametri sono opzionali: se assenti il filtro relativo viene ignorato.
     *
     * @param array $parametri Chiavi supportate:
     *   'parola_chiave' (string) — ricerca su titolo e descrizione (LIKE)
     *   'categoria'     (string) — filtro sulla categoria dell'opera
     *   'ordinamento'   (string) — 'prezzo_asc', 'prezzo_desc', 'recenti' (default)
     * @return EOpera[]|null
     */
    public static function ricercaFiltrata(array $parametri): ?array {
        $params = [];

        // Base della query — solo opere pubblicate
        $query = "SELECT o.*,
                         u.nome     AS artista_nome,
                         u.cognome  AS artista_cognome,
                         u.email    AS artista_email,
                         u.nickname AS artista_nickname
                  FROM " . static::$table . " o
                  INNER JOIN UTENTE u ON o.idArtista = u.id
                  WHERE o.stato IN ('pubblicata','in_vendita')
                  AND u.stato_account != 'Bannato'";

        // Filtro per parola chiave su titolo e descrizione
        if (!empty($parametri['parola_chiave'])) {
            $query           .= " AND (o.titolo LIKE :kw OR o.descrizione LIKE :kw)";
            $params[':kw']    = '%' . $parametri['parola_chiave'] . '%';
        }

        // Filtro per categoria
        if (!empty($parametri['categoria'])) {
            $query              .= " AND o.categoria = :categoria";
            $params[':categoria'] = $parametri['categoria'];
        }
        // Filtro prezzo massimo
if (!empty($parametri['prezzo_max'])) {
    $query             .= " AND o.prezzo <= :prezzo_max";
    $params[':prezzo_max'] = (float) $parametri['prezzo_max'];
}

        // Ordinamento
        $ordinamento = $parametri['ordinamento'] ?? 'recenti';
        $query .= match ($ordinamento) {
            'prezzo_asc'  => " ORDER BY o.prezzo ASC",
            'prezzo_desc' => " ORDER BY o.prezzo DESC",
            default       => " ORDER BY o.id DESC",   // 'recenti' o non specificato
        };

        $db     = FDataBase::getInstance();
        $result = $db->queryDB($query, $params);

        if ($result === null) {
            return null;
        }

        $opere = [];
        foreach ($result as $row) {
            $opere[] = self::creaOperaDaArray($row);
        }
        return $opere;
    }

    // ---------------------------------------------------------------------------
    // Metodo privato di supporto
    // ---------------------------------------------------------------------------

    /**
     * Costruisce un'istanza di EOpera (con EArtista annidato) a partire
     * da un array prodotto dalle query JOIN di questo Foundation.
     *
     * I campi dell'artista sono aliasati (artista_nome, artista_cognome…)
     * per evitare conflitti con le colonne omonime di OPERA.
     *
     * ATTENZIONE: EArtista è costruito con i soli campi disponibili dalla JOIN.
     * Non chiamare getArtista()->getBiografia() o ->getCartaIdentita() su oggetti
     * restituiti da questo metodo: i campi non estratti dalla query saranno vuoti.
     */
    private static function creaOperaDaArray(array $row): EOpera {
        $artista = new EArtista(
            (int) $row['idArtista'],
            $row['artista_nome'],
            $row['artista_cognome'],
             new DateTimeImmutable('1990-01-01'),
            '',             // indirizzo: non estratto in questa query
            $row['artista_nickname'],
            '',             // telefono: non estratto in questa query
            $row['artista_email'],
            '',             // password: mai esposta nelle query di lettura
            null,           // immagine_profilo
            EUtente::STATO_ATTIVO,
            '',             // biografia: non estratta in questa query
            '',             // stile_artistico: non estratto in questa query
            '',             // carta_identita: non estratta in questa query
            EArtista::STATO_IN_ATTESA
        );
        $statoOpera = match($row['stato']) {
    'in_vendita' => new EStatoInVendita(),
    'Venduta'    => new EStatoVenduto(),
    default      => new EStatoInserito(),
};
        $opera = new EOpera(
            (int) $row['id'],
            $row['titolo'],
            (int)   $row['anno'],
            new ETecnica(0, $row['tecnica']),
            $row['dimensioni'],
            
            $row['descrizione'],
            
            new EPrezzo((float) $row['prezzo'], 'EUR'),
            $statoOpera,
            $artista,
             new ECategoria($row['categoria'])
        );
        //$opera->setId((int) $row['id']);
        $db = FDataBase::getInstance();
$resImmagine = $db->queryDB(
    "SELECT nome_file FROM immagine WHERE idOpera = :id ORDER BY id ASC LIMIT 1",
    [':id' => (int)$row['id']]
);

if ($resImmagine && !empty($resImmagine[0]['nome_file'])) {
    $immagine = new EImmagine(0, $resImmagine[0]['nome_file']);
    $opera->addImmagine($immagine);
}
        return $opera;
    }
}
?>