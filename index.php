<?php
date_default_timezone_set("America/Sao_Paulo");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

echo password_hash('password', PASSWORD_DEFAULT);

require './vendor/autoload.php';
include './src/routes/api.php';
include './src/routes/web.php';