<?php

class Crud
{

    private $servername = "localhost";
    private $username = "webshop_Lydia";
    private $password = "shoplvg";
    private $dbname = "lydia_webshop";
    private $pdo;

    public function __construct()
    {
        if (!$this->pdo) {
            $connectionString = "mysql:host=$this->servername;dbname=$this->dbname";
            $this->pdo = new PDO($connectionString, $this->username, $this->password);
        }
    }

    private function prepareAndBind($sql, $params, $class = NULL)
    {

        $stmt = $this->pdo->prepare($sql);
        if ($stmt) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            if ($class) { // To fetch class objects (User/Product)
                $stmt->setFetchMode(PDO::FETCH_CLASS, $class);
            }

            $stmt->execute();
            return $stmt;
        }
    }

    public function createRow($sql, $params)
    {
        $this->prepareAndBind($sql, $params);
        // returns ID of inserted row
        return $this->pdo->lastInsertId();
    }

    public function readOneRow($sql, $params, $class)
    {
        $stmt = $this->prepareAndBind($sql, $params, $class);
        $readObject = $stmt->fetch();
        // returns an object or class
        return $readObject;
    }

    public function readMultipleRows($sql, $params, $class)
    {
        $stmt = $this->prepareAndBind($sql, $params, $class);
        $readArray = $stmt->fetchAll();
        // returns an array of objects or classes
        return $readArray;
    }

    public function updateRow($sql, $params)
    {
        $stmt = $this->prepareAndBind($sql, $params);
    }

    public function deleteRow($sql, $params)
    {
        $stmt = $this->prepareAndBind($sql, $params);
    }
}
