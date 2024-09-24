<?php

try{
    $hostname = "us-cluster-east-01.k8s.cleardb.net";
    $database = "heroku_43a832b78e5afea";
    $username = "bb382738f2554e";
    $password = "e233fd5f";

    $mysqli = new mysqli($hostname,$username,$password,$database);

    if($mysqli->connect_error){
        die("Falha na conexão: " . $mysqli->connect_error);
    }
}catch(Exception $exception){
    echo $exception->getMessage();
}