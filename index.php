<?php
date_default_timezone_set("America/Sao_Paulo");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");

require './vendor/autoload.php';

try {
print_r((new App\User())->all());
} catch (\Exception $e) {
  echo $e->getMessage();
}
  

include './src/routes/api.php';
include './src/routes/web.php';
