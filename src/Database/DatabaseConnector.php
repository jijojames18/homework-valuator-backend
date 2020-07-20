<?php
namespace Database;

class DatabaseConnector
{
    private $db = null;

    public function __construct()
    {
        try
        {
            $this->db = new \PDO("mysql:host=localhost;dbname=" . DB_NAME . ";charset=UTF8", DB_USER, DB_PASSWORD);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            exit($e->getMessage());
        }
    }


    public function getConnection()
    {
        return $this->db;
    }
}

