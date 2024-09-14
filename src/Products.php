<?php

namespace Juninho\CarrinhosCompras;

class Products{
    
    protected $name = "";
    protected $description = "";
    protected $price = 0;
    public $id;

    public function __construct($name, $description, $price, $id = 1)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->id = $id;
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
   public function getID(){
    return $this->id;
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
   public function setId($id){
    $this->id = $id;
   }
}
