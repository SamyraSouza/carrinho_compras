<?php

namespace App;

class Products extends Model
{
    protected $name = "";
    protected $description = "";
    protected $price = 0;
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price'];
    protected $accessible = ['name', 'description', 'price', 'id'];


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
