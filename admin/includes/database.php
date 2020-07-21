<?php

require_once('new_config.php');

class Database
{
    public $connection;
    private $db;
    function __construct()
    {
        $this->db = $this->openConnection();
    }

    public function openConnection()
    {

//        $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            die('Mysql connection failed badly' . $this->connection->connect_error);
        }
        return $this->connection;
    }


    public function query($sql)
    {
        $result = $this->db->query($sql);

        $this->confirmQuery($result);

        return $result;
    }

    private function confirmQuery($result)
    {
        if (!$result) {
            die('Query failed' . $this->db->error);
        }
    }

    public function escapeString($string)
    {
        return $this->db->real_escape_string($string);
    }

    public function insertId()
    {
        return $this->db->insert_id;
    }


    public function theInsertId()
    {
        return mysqli_insert_id($this->db);
    }

}

$database = new Database();



