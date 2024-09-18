<?php

require './vendor/autoload.php';

use Juninho\CarrinhosCompras\Cart;
use Juninho\CarrinhosCompras\core\Database;
use Juninho\CarrinhosCompras\Products;
use Juninho\CarrinhosCompras\services\AuthService;
use Juninho\CarrinhosCompras\services\CartService;
use Juninho\CarrinhosCompras\services\ProductService;
use Juninho\CarrinhosCompras\services\UserService;
use Juninho\CarrinhosCompras\User;

try {
   
$cart_service = new CartService();
$cart_service->openCart(3);

} catch (Exception $exception) {
    echo $exception->getMessage();
}
