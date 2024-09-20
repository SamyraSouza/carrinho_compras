<?php

namespace App;

class Order extends Model
{
    protected $cart_id = 0;
    protected $total = 0;
    protected $user_id= "";
    protected $table = "sales_order";
    protected $fillable = ["cart_id", "total", 'user_id'];
    protected $accessible = ['cart_id', 'total', 'user_id', 'id'];

    
    public function getCart(){
        return $this->cart_id;
    }
    public function getValue(){
        return $this->total;
    }
    public function getUser(){
        return $this->user_id;
    }
    public function setCart($cart_id){
        $this->cart_id = $cart_id;
    }
    public function setValue($total){
        $this->total = $total;
    }
    public function setUser($user_id){
        $this->user_id = $user_id;
    }
}
