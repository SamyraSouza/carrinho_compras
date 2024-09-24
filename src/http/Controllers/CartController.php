<?php

namespace App\http\Controllers;

use Exception;
use App\services\CartService;

class CartController extends Controller
{

    protected $service;

    public function __construct()
    {
        $this->service = new CartService();
    }

    public function addProduct($params, $request){
        try{
            $add_product = $this->service->addProduct($request["product_id"], $request["cart_id"]);
            $this->respondsWith(200, "Produto adicionado ao carrinho com sucesso"); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Não foi possível adicionar o produto ao carrinho"); 
        }
    }

    public function getCart($params){
        try{
            $cart = $this->service->readOneCart($params["id"]);
            $this->respondsWith(200, "Carrinho localizado", ["cart" => $cart->toArray()]); 
        }catch(Exception $exception){
            $this->respondsWith(404, "Carrinho não encontrado"); 
        }
    }

    public function getCarts($params, $request){

        unset($request["user_token"]);

        try{
            $carts = $this->service->read($request);
            $carts = array_map(function($cart){
               foreach($cart["products"] as $key => $product){
                $cart["products"][$key] = $product->toArray();
               }
               return $cart;
            }, $carts);
            $this->respondsWith(200, "Carrinhos localizados", ["cart" => $carts]); 
        }catch(Exception $excepiton){
            $this->respondsWith(404, "Carrinhos não localizados"); 
        }
    }

    public function open($params){
        try{
            $cart = $this->service->openCart($params["id"]);
            $this->respondsWith(200, "Carrinho aberto"); 
        }catch(Exception $excepiton){
            $this->respondsWith(500, "Carrinho não aberto"); 
        }
    }

    public function close($params, $request){
        try{
            $cart = $this->service->closeCart($params["id"], $request["user_token"]);
            $this->respondsWith(200, "Carrinho fechado"); 
        }catch(Exception $excepiton){
            $this->respondsWith(500, "Carrinho não fechado"); 
        }
    }
}
