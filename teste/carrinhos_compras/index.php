<?php

require './vendor/autoload.php';

use Juninho\CarrinhosCompras\Cart;
use Juninho\CarrinhosCompras\Products;
use Juninho\CarrinhosCompras\Order;

    $camiseta= new Products("camiseta","algodao", 20);

    $shorts = new Products("shorts", "jeans", 20);

    $caneta = new Products("caneta", "preta", 2);

    $cart = new Cart(2);

    $cart->addProducts($camiseta);
    $cart->addProducts($shorts);
    $cart->addProducts($caneta);

echo '<pre>';
    print_r($cart);
echo '</pre>';


