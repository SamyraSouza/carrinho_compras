<?php

namespace App\services;

use App\Products;

class ProductService
{

    public function make($name, $description, $price)
    {
        $product = new Products();
        $product->initConnection();
        $product->setname($name);
        $product->setdescription($description);
        $product->setprice($price);
        $product->save();
        $product->last();
        $product->closeConnection();
        return $product;
    }

    public function read()
    {
        $product = new Products();
        $product->initConnection();
        $products = $product->all();
        $product->closeConnection();
        return $products;
    }

    public function deletes($id)
    {
        $product = new Products();
        $product->initConnection();
        $product->find($id);
        $product->delete();
        $product->closeConnection();
    }

    public function update($id, $data)
    {
        $product = new Products();
        $product->initConnection();
        $product->find($id);
        if (isset($data["name"])) {
            $product->setname($data["name"]);
        }
        if (isset($data["description"])) {
            $product->setdescription($data["description"]);
        }
        if (isset($data["price"])) {
            $product->setprice($data["price"]);
        }
        $product->save();
        $product->closeConnection();
    }
}
