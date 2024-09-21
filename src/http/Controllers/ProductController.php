<?php

namespace App\http\Controllers;

use Exception;
use App\services\ProductService;

class ProductController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ProductService();  
    }
    public function create($params, $request){
        try{
            $product = $this->service->make($request["name"], $request["description"], $request["price"]);
            $this->respondsWith(200, "Produto criado", $product->toArray()); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Produto não criado"); 
        }
    }

    public function list(){
        try{
            $products = $this->service->read();
            $this->respondsWith(200, "Produtos encontrados", ["products" => $products]); 
        }catch(Exception $exception){
            $this->respondsWith(404, "Produtos não encontrados"); 
        }
    }

    public function update($params, $request){
        try{
            $product = $this->service->update($params["id"], $request);
            $this->respondsWith(200, "Produto atualizado", $product->toArray()); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Produto não atualizado"); 
        }
    }

    public function delete($params, $request){
        try{
            $product = $this->service->deletes($params["id"]);
            $this->respondsWith(200, "Produto deletado"); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Não foi possível deletar"); 
        }
    }
}
