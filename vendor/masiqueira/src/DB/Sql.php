<?php

namespace DB;

require('config.php');

class Sql
{
    private $conn;

    public function __construct()
    {
        $this->conn = new \PDO(
            "mysql:dbname=".DBNAME.";host=".HOSTNAME,
            USERNAME,
            PASSWORD
        );
    }

    public function setParams($statement, $parameters = array())
    {
        foreach ($parameters as $key => $value) {
            $this->bindParam($statement, $key, $value);
        }
    }

    public function bindParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params= array())
    {
        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);
        $stmt->execute();
    }

    public function select($rawQuery, $params= array())
    {

        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}