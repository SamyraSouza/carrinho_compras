<?php

namespace Juninho\CarrinhosCompras;
use Juninho\CarrinhosCompras\Products;

class Cart extends Model
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
    public function setId($id){
        $this->id = $id;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function addProducts($product){
        $this->products[] = $product;
    }
    public function removeProduct($product){
  
        $delete = array_filter($this->products, function($filter_product) use ($product){
            return $filter_product->id != $product->id;
        });

        $this->products = array_values($delete);
    }
}
