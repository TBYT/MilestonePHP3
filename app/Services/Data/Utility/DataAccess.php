<?php
namespace App\Services\Data\Utility;

use mysqli;

class DataAccess
{
    //Define the connection string
    private $servername = "localhost";
    private $username = "root";
    private $password = "root";
    private $db;
    private $conn;
    
    public function __construct(string $db)
    {
        $this->db = $db;
    }
    
    //Refresh connection and return it
    public function getConnection()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
        return $this->conn;
    }
    
    //Turn on and off autocommit
    public function setAutocommit(bool $autocommit)
    {
        $this->conn->autocommit($autocommit);
    }
    
    public function beginTransaction()
    {
        $this->conn->begin_transaction();
    }
    
    public function commitTransaction()
    {
        $this->conn->commit();
    }
    
    public function rollbackTransaction()
    {
        $this->conn->rollback();
    }
    
    public function closeConnection()
    {
        $this->conn->close();
    }
}

