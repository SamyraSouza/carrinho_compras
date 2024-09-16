<?php

try{
    $hostname = "localhost";
    $database = "cart";
    $username = "root";
    $password = "";

    $mysqli = new mysqli($hostname,$username,$password,$database);

    if($mysqli->connect_error){
        die("Falha na conexão: " . $mysqli->connect_error);
    }
}catch(Exception $exception){
    echo $exception->getMessage();
}