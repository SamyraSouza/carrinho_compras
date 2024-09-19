<?php

namespace Juninho\CarrinhosCompras\services;

use Exception;
use Juninho\CarrinhosCompras\User;

class UserService
{
    public function read($id){
        $user = new User();
        $user->initConnection();
        $this->verifyUser($id);
        return $user->where(["id" => $id])[0];
        $user->closeConnection();
       
    }

    public function verifyUser($id){
        $user = new User();
        $user->initConnection();
        if($user->where(["id" => $id]) == null){
            throw new Exception("Usuário não existe");
        }
    }
 
    public function update($id, $data){
        $user = new User();
        $user->initConnection();
        $user->find($id);
        if (isset($data["name"])) {
            $user->setName($data['name']);
        }
        if (isset($data["birth_date"])) {
            $user->setName($data['birth_date']);
        }
        if (isset($data["address"])) {
            $user->setName($data['address']);
        }
        if (isset($data["cpf"])) {
            $user->setName($data['cpf']);
        }
        if (isset($data["email"])) {
            $user->setName($data['email']);
        }
        if (isset($data["password"])) {
            $user->setName($data['password']);
        }
        $user->save();
        $user->closeConnection();
    }
    
    public function remove($id){
        $user = new User();
        $user->initConnection();
        $user->find($id);
        $user->delete();
        $user->closeConnection();
    }
}
