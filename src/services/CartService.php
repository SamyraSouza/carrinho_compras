<?php

namespace Juninho\CarrinhosCompras\services;

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

    protected function create(){
        $cart = new Cart();
        $cart->initConnection();
        $cart->setStatus("Aberto");
        $cart->save();
        $cart->closeConnection();
        return $cart;
    }

    public function read(){
        $cart =  new Cart();
        $cart->initConnection();
        $cart->all();
        $cart->closeConnection();
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
