<?php

namespace Juninho\CarrinhosCompras\http\Controllers;

use Exception;
use Juninho\CarrinhosCompras\services\AuthService;
use Juninho\CarrinhosCompras\services\UserService;

class AuthController
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
        echo json_encode($token);
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function register($params, $request){
        try{
            $user = $this->service->register($request["name"], $request["birth_date"], $request["address"], $request["cpf"], $request["email"], $request["password"]);
            echo "Usuário salvo com sucesso!";
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function show($id){
        try{
            $user = $this->service_user->read($id["id"]);
            echo json_encode($user);
        }catch(Exception $exception){
            echo $exception->getMessage();
        }
    }
}
