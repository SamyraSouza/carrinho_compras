<?php

namespace App\core;

use FTP\Connection;
use mysqli;

class Database
{
    private $hostname = "localhost";
    private $database = "cart";
    private $username = "root";
    private $password = "";
    private $connection;

    public function __construct()
    {             
        $mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if($mysqli->connect_error){
            die("Falha na conexão: " . $mysqli->connect_error);
        }    
        $this->connection = $mysqli;
    }

    public function getConnection(){
        return $this->connection;
    }

}