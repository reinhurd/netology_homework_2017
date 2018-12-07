<?php

class MySQL
{
    private $pdo;
    public function __construct($dbSettings)
    {
        $this->pdo = new PDO('mysql:dbname='.$dbSettings['dbName'].';host='.$dbSettings['host'], $dbSettings['login'], $dbSettings['password']);
        $this->pdo->query('SET NAMES utf8');
    }

	public function complexQuery($table, $data)
	{
        $Stmt = $this->pdo->prepare("SELECT * FROM $table WHERE author LIKE ? AND name LIKE ? AND isbn LIKE ?");
        $author="%" . $data["author"] . "%";
        $name="%" . $data["name"] . "%";
        $isbn="%" . $data["isbn"] . "%";
        $Stmt->bindParam(1, $author);
        $Stmt->bindParam(2, $name);
        $Stmt->bindParam(3, $isbn);
	    $Stmt->execute();
		return $Stmt->fetchAll();
	}
}