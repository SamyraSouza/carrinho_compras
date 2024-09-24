<?php

namespace App\http\Controllers;

use App\PersonalAccessToken;
use Exception;
use App\services\AuthService;
use App\services\PersonalAccessTokenService;
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
            $this->respondsWith(401, $exception->getMessage()); 
        }
    }

    public function register($params, $request){
        try{
            $user = $this->service->register($request["name"], $request["birth_date"], $request["address"], $request["cpf"], $request["email"], $request["password"]);
            $this->respondsWith(201, "Usuário salvo com sucesso", ["Data" => $user->toArray() ]); 
        }catch(Exception $exception){
            $this->respondsWith(400, "Não foi possível registrar o usuário"); 
        }
    }

    public function show($params, $request){
        try{
            $access = new AuthService();
            $user = $access->getUserByToken($request["user_token"]);
            $this->respondsWith(200, "Dados do usuário localizados", ["user"=>$user->toArray()]); 

   
        }catch(Exception $exception){
            $this->respondsWith(404, "Não foi possível localizar o usuário"); 
        }
    }
}
