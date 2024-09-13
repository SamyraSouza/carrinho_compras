<?php

namespace Juninho\CarrinhosCompras;

class Products{
    
    protected $name = "";
    protected $description = "";
    protected $price = 0;

    public function __construct($name, $description, $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

   public function getname(){
    return $this->name;
   }
   public function getdescription(){
    return $this->description;
   }
   public function getprice(){
    return $this->price;
   }

   public function setname($name){
    $this->name = $name;
   }
   public function setdescription($description){
    $this->description = $description;
   }
   public function setprice($price){
    $this->price = $price;
   }
}
