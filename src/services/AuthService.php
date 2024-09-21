<?php

namespace App\services;

use Exception;
use App\PersonalAccessToken;
use App\User;
use Carbon\Carbon;

class AuthService 
{
    public function register($name, $birth_date, $address, $cpf, $email, $password){

        $verify_email = $this->verifyEmail($email);
        if($verify_email == 1){
            throw new Exception("Email já cadastrado");
        }
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
        $saved = $user->save();
        if(!$saved){
            throw new Exception("Não foi possível salvar seu usuário.");
        }
        $user->closeConnection();
        return $user;
    }


    public function verifyEmail($email){
        $user = new User();
        $user->initConnection();
        $user_email = $user->where(["email" => $email]);
        $user->closeConnection();
        if(empty($user_email)){
            return 0;
        }
            return 1;
    }

    public function login($email, $password){
        $user = new User();
        $user->initConnection();
        $user_login = $user->where(["email" => $email]);
        if(empty($user_login)){
            throw new Exception("Usuário não existe");
        }
        $password_login = $user_login[0]["password"];
        $verified = password_verify($password, $password_login);
        if($verified){
            $access = new PersonalAccessTokenService();
           return $access->create($user_login[0]["id"]);          
        }
        else{
            throw new Exception("Não autorizado");
        }
        $user->closeConnection();
    }

    public function getUserByToken($token){
        $access = new PersonalAccessToken();
        $access->initConnection();
        $result = $access->where(["token" => $token]);
        $user_id = $result[0]['user_id'];
        $user = new User();
        $user->initConnection();
        $user->find($user_id);
        $user->closeConnection();
        return $user;
    }

    public function verifyTokenValidated($token){
        $access = new PersonalAccessToken();
        $access->initConnection();
        $result = $access->where(["token" => $token]);
        $result_date = Carbon::createFromFormat('Y-m-d H:i:s',  $result[0]["expired_at"]);
        if($result_date < Carbon::now()){
            return false;
        }else{
            return true;
        }
    }

    public function deleteOldTokens($user_id){
        $delete_tokens =  [];
        $tokens = new PersonalAccessToken();
        $tokens->initConnection();
        $results = $tokens->where(["user_id" => $user_id]);
        $tokens->closeConnection();
        foreach ($results as $delete_tokens) {
            $token = new PersonalAccessToken();
            $token->initConnection();
            $token->find($delete_tokens["id"]);
            $token->delete();
        }
    }
}
