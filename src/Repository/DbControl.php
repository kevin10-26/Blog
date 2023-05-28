<?php declare(strict_types=1);

namespace Blog\Repository;

use \PDO;

class DbControl {

	private $_host = '127.0.0.1';
	private $_dbName = 'blog';
	private $_username = 'root';
	private $_passwd = '';
	private $_options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names = 'fr_FR'",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);

	private function connect()
	{
		try {

			$pdo = new PDO('mysql:host=' . $this->_host . ';dbname=' . $this->_dbName . ';charset=utf8', $this->_username, $this->_passwd, $this->_options);

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
}