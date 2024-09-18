<?php

namespace Juninho\CarrinhosCompras\services;

use Exception;
use Juninho\CarrinhosCompras\Cart;
use Juninho\CarrinhosCompras\CartProducts;
use Juninho\CarrinhosCompras\Products;

class CartService
{
    public function addProduct($product_id,$cart_id=null){
        if($cart_id){
            $cart_product =  new CartProducts();
            $cart_product->initConnection();
            $cart_product->setProductId($product_id);
            $cart_id->setCartId($cart_id);
            $cart_id->save();
            $cart_id->closeConnection();
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

    public function closeCart($id){
        $cart = new Cart();
        $cart->initConnection();
        $cart->find($id);
        $cart->setStatus("Fechado");
        $closed = $cart->save();
        if($closed){
            $service = new OrderService();
            $service->updateOrderSituation($cart->getId());
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

    public function read(){
        $carts =  new Cart();
        $carts->initConnection();
        $carts_with_products = [];
        foreach ($carts->all() as $cart) {
            $products = $this->getProducts($cart["id"]);
            $cart["products"] = $products;
            $carts_with_products[] = $cart;
        
        }
        $carts->closeConnection();
        return $carts_with_products;
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
