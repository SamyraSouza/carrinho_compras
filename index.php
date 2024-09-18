<?php

require './vendor/autoload.php';

use Juninho\CarrinhosCompras\Cart;
use Juninho\CarrinhosCompras\core\Database;
use Juninho\CarrinhosCompras\Products;
use Juninho\CarrinhosCompras\services\CartService;
use Juninho\CarrinhosCompras\services\ProductService;



try {
    $cart = new CartService();
    $products = $cart->getProducts(1);
    echo "<pre>";
    print_r($products);
    echo "</pre>";
} catch (Exception $exception) {
    echo $exception->getMessage();
}
