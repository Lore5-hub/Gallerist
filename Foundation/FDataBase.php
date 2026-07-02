<?php

if(file_exists(dirname(__DIR__) . '/config.inc.php')) require_once dirname(__DIR__) . '/config.inc.php';

/**
 * La classe FDataBase fornisce il motore di persistenza di basso livello basato su PDO.
 * Applica il pattern Singleton ed espone sia metodi CRUD generici basati su Reflection,
 * sia metodi personalizzati per le interrogazioni complesse dei casi d'uso.
 * * @package Foundation
 */
class FDataBase
{
	/** @var FDataBase L'unica istanza della classe (Singleton) */
	private static $instance;
	
	/** @var PDO Oggetto PDO che effettua la connessione al DBMS */
	private $db;

	/**
	 * Costruttore privato: l'unico accesso è dato dal metodo getInstance()
	 */
	private function __construct ()
	{
		try {
			// Connessione al database usando le variabili globali definite in config.inc.php
			$this->db = new PDO ("mysql:dbname=".$GLOBALS['database'].";host=localhost; charset=utf8;", $GLOBALS['username'], $GLOBALS['password']);
		} catch (PDOException $e) {
			echo "Attenzione errore in connessione: " . $e->getMessage();
			die;
		}
	}

	/**
	 * Metodo statico per restituire l'unica istanza dell'oggetto.
	 * @return FDataBase L'istanza dell'oggetto.
	 */
	public static function getInstance ()
	{
		if (self::$instance == null) {
			self::$instance = new FDatabase();
		}
		return self::$instance;
	}

	/**
	 * Metodo generico per salvare le informazioni di un oggetto Entity sul database.
	 * Sfrutta la Reflection richiamando i metodi statici della classe Foundation passata.
	 * * @param string $class Nome della classe Foundation specifica (es. "FOpera")
	 * @param object $obj Oggetto Entity da salvare (es. istanza di EOpera)
	 * @return string|null L'ID dell'ultima riga inserita o null in caso di errore
	 */
	public function storeDB ($class, $obj)
	{
		try {
			$this->db->beginTransaction();
			$query = "INSERT INTO " . $class::getTable() . " VALUES " . $class::getValues();
			$stmt = $this->db->prepare($query);
			$class::bind($stmt, $obj);
			$stmt->execute();
			$id = $this->db->lastInsertId();
			$this->db->commit();
			$this->closeDbConnection();
			return $id;
		} catch (PDOException $e) {
			echo "Attenzione errore in storeDB: " . $e->getMessage();
			$this->db->rollBack();
			return null;
		}
	}

	/**
	 * Metodo generico per caricare record dal database in base a un determinato campo e valore.
	 * Gestisce automaticamente riscontri singoli (restituisce un array associativo) o multipli (array di array).
	 * * @param string $class Nome della classe Foundation specifica
	 * @param string $field Il nome della colonna sul DB (es. "id" o "idArtista")
	 * @param mixed $id Il valore da cercare nella colonna
	 * @return array|null I dati estratti dal DB sotto forma di array o null
	 */
	public function loadDB ($class, $field, $id)
	{
		try {
			$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$num = $stmt->rowCount();
			
			if ($num == 0) {
				$result = null; 
			} elseif ($num == 1) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC); // Ritorna una sola riga (array associativo)
			} else {
				$result = array(); 
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				while ($row = $stmt->fetch())
					$result[] = $row; // Ritorna un array di righe
			}
			return $result;
		} catch (PDOException $e) {
			echo "Attenzione errore in loadDB: " . $e->getMessage();
			return null;
		}
	}

	/**
	 * Metodo generico che restituisce il numero di righe interessate da una query di selezione.
	 * * @param string $class Nome della classe Foundation specifica
	 * @param string $field Il campo usato per la ricerca
	 * @param mixed $id Il valore usato per la ricerca
	 * @return int|null Il numero di righe colpite
	 */
	public function interestedRows ($class, $field, $id)
	{
		try {
			$this->db->beginTransaction();
			$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$num = $stmt->rowCount();
			$this->closeDbConnection();
			return $num;
		} catch (PDOException $e) {
			echo "Attenzione errore in interestedRows: " . $e->getMessage();
			$this->db->rollBack();
			return null;
		}
	}

	/**
	 * Metodo generico che permette di eliminare un record nel DB.
	 * * @param string $class Nome della classe Foundation specifica
	 * @param string $field Il campo usato come clausola di cancellazione
	 * @param mixed $id Il valore associato al campo
	 * @return bool|null True se l'eliminazione ha successo, null altrimenti
	 */
	public function deleteDB ($class, $field, $id)
	{
		try {
			$result = null;
			$this->db->beginTransaction();
			$esiste = $this->existDB($class, $field, $id);
			if ($esiste) {
				$query = "DELETE FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "';";
				$stmt = $this->db->prepare($query);
				$stmt->execute();
				$this->db->commit();
				$this->closeDbConnection();
				$result = true;
			}
		} catch (PDOException $e) {
			echo "Attenzione errore in deleteDB: " . $e->getMessage();
			$this->db->rollBack();
		}
		return $result;
	}

	/**
	 * Metodo generico che permette di aggiornare il valore di un singolo attributo sul DB.
	 * * @param string $class Nome della classe Foundation specifica
	 * @param string $field Il nome del campo da aggiornare
	 * @param mixed $newvalue Il nuovo valore da inserire
	 * @param string $pk Il nome della colonna chiave primaria (es. "id")
	 * @param mixed $id Il valore della chiave primaria per identificare il record
	 * @return bool True in caso di successo, false altrimenti
	 */
	public function updateDB ($class, $field, $newvalue, $pk, $id)
	{
		try {
			$this->db->beginTransaction();
			$query = "UPDATE " . $class::getTable() . " SET " . $field . "='" . $newvalue . "' WHERE " . $pk . "='" . $id . "';";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$this->db->commit();
			$this->closeDbConnection();
			return true;
		} catch (PDOException $e) {
			echo "Attenzione errore in updateDB: " . $e->getMessage();
			$this->db->rollBack();
			return false;
		}
	}

	/**
	 * Metodo generico che verifica l'esistenza di un record e ne restituisce i dati grezzi.
	 * * @param string $class Nome della classe Foundation specifica
	 * @param string $field Campo della classe su cui effettuare la ricerca
	 * @param mixed $id Valore da cercare
	 * @return array|null I dati trovati (array a un livello se singolo, array di array se multipli) o null
	 */
	public function existDB ($class, $field, $id)
	{
		try {
			$query = "SELECT * FROM " . $class::getTable() . " WHERE " . $field . "='" . $id . "'";
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$this->closeDbConnection();
			
			if (count($result) == 1) {
				return $result[0]; 
			} else if (count($result) > 1) {
				return $result; 
			}
			return null;
		} catch (PDOException $e) {
			echo "Attenzione errore in existDB: " . $e->getMessage();
			return null;
		}
	}

	/**
	 * METODO SPECIFICO PER UC6 (Statistiche Vendite Artista)
	 * Estrae gli ordini ricevuti da uno specifico artista all'interno di un intervallo temporale.
	 * Sfrutta lo stesso schema di ritorno delle query complesse del file originale (array dei dati + numero righe).
	 * * @param int $idArtista L'identificativo dell'artista
	 * @param string $dataInizio Data iniziale nel formato 'Y-m-d'
	 * @param string $dataFine Data finale nel formato 'Y-m-d'
	 * @return array Contiene in posizione 0 i risultati ($result) e in posizione 1 il numero di righe ($num)
	 */
	public function loadOrdiniFiltrati ($idArtista, $dataInizio, $dataFine)
	{
		try {
			$class = "FOrdine";
			// Query con filtro sull'artista e intervallo temporale (BETWEEN) per il calendario dell'UC6
			$query = "SELECT * FROM " . $class::getTable() . " WHERE idArtista = '" . $idArtista . "' AND dataOrdine BETWEEN '" . $dataInizio . "' AND '" . $dataFine . "' ORDER BY dataOrdine DESC;";
			
			$stmt = $this->db->prepare($query);
			$stmt->execute();
			$num = $stmt->rowCount();
			
			if ($num == 0) {
				$result = null;
			} elseif ($num == 1) {
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
			} else {
				$result = array();
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				while ($row = $stmt->fetch())
					$result[] = $row;
			}
			return array($result, $num);
		} catch (PDOException $e) {
			echo "Attenzione errore in loadOrdiniFiltrati: " . $e->getMessage();
			return array(null, 0);
		}
	}

	//Metodo per query JOIN personalizzate
	public function queryDB(string $sql, array $params = []): array|null {
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->execute($params);
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return empty($result) ? null : $result;
		} catch (PDOException $e) {
			error_log("Errore in queryDB: " . $e->getMessage());
			return null;
		}
	}
public function getConnection(): PDO {
    return $this->db;
}
	/**
	 * Metodo che chiude la connessione con il DB azzerando l'istanza statica.
	 */
	public function closeDbConnection ()
	{
		self::$instance = null;
	}
}
?>