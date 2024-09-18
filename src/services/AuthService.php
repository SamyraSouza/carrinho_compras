<?php

namespace Juninho\CarrinhosCompras\services;

use Exception;
use Juninho\CarrinhosCompras\PersonalAccessToken;
use Juninho\CarrinhosCompras\User;

class AuthService
{
    public function register($name, $birth_date, $address, $cpf, $email, $password){
        $birth_date = date("Y-m-d", strtotime($birth_date));
        $password = password_hash($password, PASSWORD_DEFAULT);
        $user = new User();
        $user->initConnection();
        $user->setName($name);
        $user->setBirthDate($birth_date);
        $user->setAddress($address);
        $user->setCpf($cpf);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->save();
        $user->closeConnection();
    }

    public function login($email, $password){
        $user = new User();
        $user->initConnection();
        $user_login = $user->where(["email" => $email]);
        $password_login = $user_login[0]["password"];
        $verified = password_verify($password, $password_login);
        if($verified){
            $access = new PersonalAccessTokenService();
           return $access->create($user_login[0]["id"], $user_login[0]["email"]);          
        }
        else{
            throw new Exception("Não autorizado");
        }
        $user->closeConnection();
    }
}
