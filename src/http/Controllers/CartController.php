<?php

namespace Juninho\CarrinhosCompras\http\Controllers;

use Exception;
use Juninho\CarrinhosCompras\services\CartService;

class CartController
{
    protected $service;

    public function __construct()
    {
        $this->service = new CartService();
    }

    public function addProduct($params, $request){
        try{
            $add_product = $this->service->addProduct($request["product_id"], $request["cart_id"]);
            echo "Produto adicionado ao carrinho com sucesso!";
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function getCart($params){
        try{
            $cart = $this->service->readOneCart($params["id"]);
            echo json_encode($cart);
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    // public function getCarts($params){
    //     try{
    //         $cart = $this->service->readOneCart($params["id"]);
    //     }
    // }
}
