<?php

namespace Juninho\CarrinhosCompras\services;

use Juninho\CarrinhosCompras\CartProducts;
use Juninho\CarrinhosCompras\Order;
use Juninho\CarrinhosCompras\Products;

class OrderService
{
    public function updateOrderSituation($cart_id){
        $order = new Order();
        $order->initConnection();
        $order_result = $order->where(["cart_id" => $cart_id]);
     
        if($order_result){
            $order->find($order_result[0]["id"]);
            $cart_products = new CartProducts();
            $cart_products->initConnection();
            $cart_products = $cart_products->where(["cart_id" => $cart_id]);
            
            $total = 0;
            foreach ($cart_products as $cart_product) {
                $product = new Products();
                $product->initConnection();
                $product->find($cart_product["product_id"]);
                $price = $product->getPrice();
                $total += $price;
            }
            $order->setValue($total);
            $order->save();
        }else{
            $order->setCart($cart_id);
            $cart_products = new CartProducts();
            $cart_products->initConnection();
            $cart_products = $cart_products->where(["cart_id" => $cart_id]);

            $total = 0;

            foreach ($cart_products as $cart_product) {
                $product = new Products();
                $product->initConnection();
                $product->find($cart_product["product_id"]);
                $price = $product->getPrice();
                $total += $price;
            }
                $order->setValue($total);
                $order->save();
        }

    }
}
