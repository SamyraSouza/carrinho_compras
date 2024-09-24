<?php

namespace App\core;

use FTP\Connection;
use mysqli;

class Database
{
    private $hostname = "us-cluster-east-01.k8s.cleardb.net";
    private $database = "heroku_43a832b78e5afea";
    private $username = "bb382738f2554e";
    private $password = "e233fd5f";
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