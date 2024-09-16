<?php

namespace Juninho\CarrinhosCompras;

class Order extends Model
{
    protected $cart_id = 0;
    protected $total = 0;
    protected $user = "";

    
    public function getCart(){
        return $this->cart_id;
    }
    public function getValue(){
        return $this->total;
    }
    public function getUser(){
        return $this->user;
    }
    public function setCart($cart_id){
        $this->cart_id = $cart_id;
    }
    public function setValue($total){
        $this->total = $total;
    }
    public function setUser($user){
        $this->user = $user;
    }
}
