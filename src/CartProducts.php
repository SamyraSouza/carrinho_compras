<?php

namespace Juninho\CarrinhosCompras;

class CartProducts extends Model
{
    protected $cart_id = 0;
    protected $product_id = 0;
    protected $id;
    protected $fillable = ['cart_id', 'product_id'];
    protected $table = "cart_products";

    public function getCartId(){
        return $this->cart_id;
    }
    public function getProductsId(){
        return $this->product_id;
    }
    public function getId(){
        return $this->id;
    }
    public function setCartId($cart_id){
        $this->cart_id = $cart_id;
    }
    public function setProductId($product_id){
        $this->product_id = $product_id;
    }
    public function setId($id){
        $this->id = $id;
    }
}
