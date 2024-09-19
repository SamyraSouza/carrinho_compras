<?php

namespace Juninho\CarrinhosCompras\http\Controllers;

use Exception;
use Juninho\CarrinhosCompras\services\ProductService;

class ProductController
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductService();  
    }
    public function create($params, $request){
        try{
            $product = $this->service->make($request["name"], $request["description"], $request["price"]);
            echo "Produto salvo com sucesso!";
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function list(){
        try{
            $products = $this->service->read();
            echo json_encode($products);
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function update($params, $request){
        try{
            $product = $this->service->update($params["id"], $request);
            echo "Produto atualizado com sucesso!";
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }
}
