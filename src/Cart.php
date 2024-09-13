<?php

namespace Juninho\CarrinhosCompras;

class Cart
{
    protected $products = [];
    protected $id;
    protected $status;
    
    public function __construct($id = 1)
    {
        $this->id = $id;
        $this->status = "Aberto";
    }

    public function getProducts(){
        return $this->products;
    }
    public function getId(){
        return $this->id;
    }
    public function getStatus(){
        return $this->status;
    }
    public function addProducts($product){
        $this->products[] = $product;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setStatus($status){
        $this->status = $status;
    }
}
