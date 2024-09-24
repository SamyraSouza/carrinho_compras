<?php

namespace App\services;

use Exception;
use App\Cart;
use App\CartProducts;
use App\Products;

class CartService
{

    public function addProduct($product_id,$cart_id=null){
        if($cart_id){
            $cart_product =  new CartProducts();
            $cart_product->initConnection();
            $cart_product->setProductId($product_id);
            $cart_product->setCartId($cart_id);
            $cart_product->save();
            $cart_product->closeConnection();
        }else{
            $cart = $this->create();
            $cart_product =  new CartProducts();
            $cart_product->initConnection();
            $cart_product->setProductId($product_id);
            $cart_product->setCartId($cart->getId());
            $cart_product->closeConnection();
        }
        return $cart_product;
    }

    public function removeFromCart($product_id, $cart_id){
        $product = new CartProducts();
        $product->initConnection();
        $cart_product = $product->where(["product_id" => $product_id, "cart_id" => $cart_id]);
        $product->setId($cart_product[0]["id"]);
        $product->delete();
        $product->closeConnection();
    }

    public function closeCart($id, $user_token){
        $cart = new Cart();
        $cart->initConnection();
        $cart->find($id);
        $cart->setStatus("Fechado");
        $closed = $cart->save();
        $cart->closeConnection();
        if($closed){
            $service = new OrderService();
            $authService = new AuthService();
            $user = $authService->getUserByToken($user_token);
            $service->updateOrderSituation($cart->getId(), $user->getId());
        }else{
            throw new Exception("Erro ao fechar carrinho");
        }
    }

    public function openCart($id){
        $cart = new Cart();
        $cart->initConnection();
        $cart->find($id);
        $cart->setStatus("Aberto");
        $cart->save();
    }

    protected function create(){
        $cart = new Cart();
        $cart->initConnection();
        $cart->setStatus("Aberto");
        $cart->save();
        $cart->closeConnection();
        return $cart;
    }

    public function read($request){
        $carts =  new Cart();
        $carts->initConnection();
        $carts_with_products = [];
        foreach ($carts->whereLike($request) as $cart) {
            $products = $this->getProducts($cart["id"]);
            $cart["products"] = $products;
            $carts_with_products[] = $cart;
        }
        $carts->closeConnection();
        return $carts_with_products;
    }

    public function readOneCart($id){
        $cart =  new Cart();
        $cart->initConnection();
        $cart->find($id);
        $products = $this->getProducts($id);
        foreach($products as $product){
            $cart->addProducts($product);
        }
        $cart->closeConnection();
        return $cart;
    }
    public function getProducts($cart_id){
        $product = new CartProducts();
        $product->initConnection();
        $products= $product->where(['cart_id' => $cart_id]);
        $cart_products = [];
        foreach ($products as $product) {
            $found_product = new Products();
            $found_product->initConnection();   
            $found_product->find($product["product_id"]);     
            $cart_products[] = $found_product;
        }
        return $cart_products;
    }
}
