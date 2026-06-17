<?php

/**
 * La classe FTecnica fornisce i metodi di mappatura e binding per l'entità ETecnica.
 * Interagisce con la tabella 'tecnica' del database.
 * @package Foundation
 */
class FTecnica extends FDataBase
{
	/** @var string Nome della tabella sul database */
	private static $table = "tecnica";

	/** @var string Segnaposto per le query di inserimento generiche */
	private static $values = "(:id, :nome, :descrizione)";

	/**
	 * Restituisce il nome della tabella sul DB.
	 * @return string
	 */
	public static function getTable() {
		return self::$table;
	}

	/**
	 * Restituisce la stringa dei segnaposto per l'INSERT.
	 * @return string
	 */
	public static function getValues() {
		return self::$values;
	}

	/**
	 * Effettua il binding dei parametri di un oggetto ETecnica su un PDOStatement.
	 * * @param PDOStatement $stmt L'oggetto statement di PDO
	 * @param ETecnica $tecnica L'oggetto Entity da mappare
	 */
	public static function bind($stmt, $tecnica) {
		// Se l'id è 0 o non settato, passiamo NULL così MySQL usa l'AUTO_INCREMENT
		if ($tecnica->getId() === 0) {
			$stmt->bindValue(':id', null, PDO::PARAM_INT);
		} else {
			$stmt->bindValue(':id', $tecnica->getId(), PDO::PARAM_INT);
		}
		
		$stmt->bindValue(':nome', $tecnica->getNome(), PDO::PARAM_STR);
		$stmt->bindValue(':descrizione', $tecnica->getDescrizione(), PDO::PARAM_STR);
	}

	/**
	 * Trasforma una riga grezza del database (array associativo) in un oggetto Entity ETecnica.
	 * * @param array $row La riga estratta dal DB
	 * @return ETecnica|null L'oggetto Entity o null se la riga è vuota
	 */
	public static function createObject($row) {
		if ($row == null) {
			return null;
		}
		return new ETecnica($row['id'], $row['nome'], $row['descrizione']);
	}
}
?>