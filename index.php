<?php

require './vendor/autoload.php';

use Juninho\CarrinhosCompras\Cart;
use Juninho\CarrinhosCompras\core\Database;
use Juninho\CarrinhosCompras\Products;

$camiseta = new Products();
$camiseta->setname('camiseta');
$camiseta->setdescription('algodão');
$camiseta->setprice(10);

try{
$camiseta->initConnection();
$camiseta->save();
print_r($camiseta->all());
}catch(Exception $exception){
    echo $exception->getMessage();
}

