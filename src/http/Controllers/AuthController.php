<?php

namespace App\http\Controllers;

use Exception;
use App\services\AuthService;
use App\services\UserService;

class AuthController extends Controller
{
    protected $service;
    protected $service_user;

    public function __construct()
    {
        $this->service = new AuthService();
        $this->service_user = new UserService();
    }
    public function login($params,$request){
        try{
        $token = $this->service->login($request["email"], $request["password"]);
        if(!empty($token)){
            $this->respondsWith(200, "Autenticado", ["Token" => $token]); 
            }else{
                throw new Exception("Sem token");
            }
        }catch(Exception $exception){
            $this->respondsWith(401, "Não Autenticado"); 
        }
    }

    public function register($params, $request){
        try{
            $user = $this->service->register($request["name"], $request["birth_date"], $request["address"], $request["cpf"], $request["email"], $request["password"]);
            $this->respondsWith(201, "Usuário salvo com sucesso"); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Não foi possível registrar o usuário"); 
        }
    }

    public function show(){
        try{
            // $user = $this->service_user->read($id["id"]);
            $this->respondsWith(200, "Dados do usuário localizados", getallheaders()); 

   
        }catch(Exception $exception){
            $this->respondsWith(404, "Não foi possível localizar o usuário"); 
        }
    }
}
