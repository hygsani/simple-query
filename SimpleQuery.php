<?php

class SimpleQuery
{

	private $conn;
	private $server;
	private $db;
	private $username;
	private $password;

	public function __construct($server, $db, $username, $password)
	{
		$this->server = $server;
		$this->db = $db;
		$this->username = $username;
		$this->password = $password;
	}

	public function connect()
	{
		try {
			$this->conn = new PDO("mysql:host=$this->server;dbname=$this->db", $this->username, $this->password);

			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			echo 'Connected';
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	// get all records
	// ex. SELECT * FROM table
	public function getAll($table)
	{
		try {
			$rs = $this->conn->query("SELECT * FROM $table");

			return $rs->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	// get one record
	// ex. SELECT * FROM table WHERE id = ?
	public function getOneById($table, $bindValue)
	{
		try {
			if (is_int($bindValue)) {
				$pk = 'id';
				$value = $bindValue;
			} elseif (is_array($bindValue)) {
				$pk = key($bindValue);
				$value = $bindValue[key($bindValue)];
			}

			$ps = $this->conn->prepare("SELECT * FROM $table WHERE $pk = ?");

			$ps->bindValue(1, $value, PDO::PARAM_INT);
			$ps->execute();

			return $ps->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	// get first record
	// ex. SELECT * FROM table ORDER BY id ASC LIMIT 1
	public function getFirst($table, $pk = 'id')
	{
		try {
			$rs = $this->conn->query("SELECT * FROM $table ORDER BY $pk ASC LIMIT 1");

			return $rs->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	// get last record
	// ex. SELECT * FROM table ORDER BY id DESC LIMIT 1
	public function getLast($table, $pk = 'id')
	{
		try {
			$rs = $this->conn->query("SELECT * FROM $table ORDER BY $pk DESC LIMIT 1");

			return $rs->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	// get all by params
	// ex. SELECT * FROM table WHERE a =|LIKE ? AND|OR b =|LIKE ?
	public function getAllByParams($table, array $params)
	{
		try {
			$parsedParams = '';

			foreach ($params as $key => $p) {
				if (count($p) > 2) {
					$parsedParams .= "$key $p[1] ? $p[2] ";
				} else {
					$parsedParams .= "$key $p[1] ?";
				}
			}

			$sql = "SELECT * FROM $table WHERE $parsedParams";

			$ps = $this->conn->prepare("SELECT * FROM $table WHERE $parsedParams");

			$i = 0;

			foreach ($params as $key => $p) {
				$value = strtoupper($p[1]) == 'LIKE' ? "%" . $p[0] . "%" : $p[0];

				$ps->bindValue(++$i, $value);
			}

			$ps->execute();

			return $ps->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

}