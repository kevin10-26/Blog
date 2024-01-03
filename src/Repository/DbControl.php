<?php declare(strict_types=1);

namespace Blog\Repository;

use \PDO;

class DbControl {

	private $_host = '';
	private $_dbName = '';
	private $_username = '';
	private $_passwd = '';
	private $_options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names = 'fr_FR'",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	private const NOT_NULLABLE = 'NOT NULL';

	private function connect()
	{
		try {

			$pdo = new PDO('mysql:host='. $this->_host .';dbname='. $this->_dbName .';charset=utf8', $this->_username, $this->_passwd, $this->_options);

		} catch (PDOException $e) {
			throw new PDOException('Connexion impossible à la base de données');
		}

		return $pdo;
	}

	protected function query($qString, $qData = [])
	{
		$db = $this->connect();

		$query = $db->prepare($qString);

		// Bind query parameters if there is any

		if (!empty($qData)) {
			for ($i = 0; $i < count($qData); $i++) {
				$query->bindParam(":{$qData[$i]['field']}", $qData[$i]['value']);
			}
		}

		$query->execute();

		$results = [];
		while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
			$results[] = $result;
		}

		return $results;
	}

	protected function insert($table, $iData)
	{
		$iData['dt_upload'] = 'NOW()';
			
		$values = implode(', ', array_keys($iData));

		// Creating a similar var for the array walk
		$tokens = array_keys($iData);

		$tokens = array_map(function($value) { return ':' . $value; }, $tokens);
		$tokens[5] = 'NOW()';
		$tokens = implode(', ', $tokens);

		$iData['content'] = htmlentities($iData['content']);

		$iQuery = 'INSERT INTO ' . $table . '(' . $values . ') VALUES (' . $tokens . ')';
		$db = $this->connect();

		$insert = $db->prepare($iQuery);	
		
		unset($iData['dt_upload']);
		// Bind params
		foreach ($iData as $k => $v) {
			$insert->bindValue(":{$k}", $v);
		}

		$insert->execute();
		// Returns the last inserted id, to add other things, like thumbnails.
		return $db->lastInsertId();
	}

	protected function update($uData, $table, $wCond, $isThumbnail = false)
	{
		if (!$isThumbnail) $uData['dt_update'] = 'NOW()';	
		
		$values = array();
		foreach ($uData as $k => $v)
		{
			if ($k === 'dt_update') {
				$param = array($k, 'NOW()');
			} else {
				$param = array($k, ':' . $k);
			}
			$param = implode(' = ', $param);
			array_push($values, $param);
		}
		
		$values = implode(', ', $values);
		$strCond = implode(' = ', $wCond);

		$uQuery = 'UPDATE ' . $table . ' SET ' . $values . ' WHERE ' . $strCond;
		$db = $this->connect();

		$update = $db->prepare($uQuery);	
			
		if (!$isThumbnail) unset($uData['dt_update']);
		// Bind params
		foreach ($uData as $k => $v) {
			$update->bindValue(":{$k}", $v);
		}

		$update->execute();

	}
	
	// $alter = $type($values)
	// Flags : nullable, after
	public function alter($table, $col, $vals, $type, $flags = null)
	{
		$alter = $type . '(' . $vals . ')';
		$aQuery = 'ALTER TABLE ' . $table . ' MODIFY COLUMN ' . $col . ' ' . $alter;
		$db = $this->connect();
		$alter = $db->prepare($aQuery);
		$alter->execute();

		$alter->closeCursor();
		return true;
	}
	
	// Abbr for 'delete', as it's a reserved word in PhP
	public function delt($table, $wCond)
	{
		$conds = array();
		$values = array();
		for ($i = 0; $i < count($wCond); $i++)
		{
			$param = ':'.$wCond[$i]['field'];
			$tmp = [$wCond[$i]['field'], $param];

			array_push($conds, implode(' = ', $tmp));

			// Values now
			array_push($values, $wCond[$i]['value']);
		}

		$conds = implode(' AND ', $conds);	

		$dString = 'DELETE FROM ' . $table . ' WHERE ' . $conds;

		$db = $this->connect();
		$deleter = $db->prepare($dString);
		
		foreach ($wCond as $k => $v) {
			$deleter->bindValue(":{$wCond[$k]['field']}", $v['value']);
		}

		$deleter->execute();
	
	}

}
