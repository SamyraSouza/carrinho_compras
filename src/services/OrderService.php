<?php

namespace App\services;

use App\CartProducts;
use App\Order;
use App\Products;

class OrderService
{
    public function updateOrderSituation($cart_id, $user_id = null){
        $order = new Order();
        $order->initConnection();
        $order_result = $order->where(["cart_id" => $cart_id]);
        $order->closeConnection();

        if($order_result){
            $order->initConnection();
            $order->find($order_result[0]["id"]);
            $order->closeConnection();
            $cart_products = new CartProducts();
            $cart_products->initConnection();
            $cart_products_result = $cart_products->where(["cart_id" => $cart_id]);
            $cart_products->closeConnection();

            $total = 0;
            foreach ($cart_products_result as $cart_product) {
                $product = new Products();
                $product->initConnection();
                $product->find($cart_product["product_id"]);
                $product->closeConnection();
                $price = $product->getPrice();
                $total += $price;
            }
            $order->setValue($total);
            $order->initConnection();
            $order->save();
            $order->closeConnection();
        }else{
            $cart_products = new CartProducts();
            $cart_products->initConnection();
            $cart_products_result = $cart_products->where(["cart_id" => $cart_id]);
            $cart_products->closeConnection();

            $total = 0;

            foreach ($cart_products_result as $cart_product) {
                $product = new Products();
                $product->initConnection();
                $product->find($cart_product["product_id"]);
                $product->closeConnection();
                $price = $product->getPrice();
                $total += $price;
            }
                $order->initConnection();
                $order->setCart($cart_id);
                $order->setValue($total);
                $order->setUser($user_id);
                $order->save();
                $order->closeConnection();
        }

    }
}
