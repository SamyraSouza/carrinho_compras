<?php

namespace App;

class User extends Model
{
    protected $id;
    protected $name;
    protected $birth_date;
    protected $address;
    protected $cpf;
    protected $email;
    protected $password;
    protected $table = 'user';
    protected $fillable = ["name", "birth_date", "address", "cpf", "email", "password"];
    protected $accessible = ["name", "birth_date", "address", "cpf", "email", "password", 'id'];
    
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
    public function getBirthDate(){
        return $this->birth_date;
    }
    public function getAddress(){
        return $this->address;
    }
    public function getCpf(){
        return $this->cpf;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setBirthDate($birth_date){
        $this->birth_date = $birth_date;
    }
    public function setAddress($address){
        $this->address = $address;
    }
    public function setCpf($cpf){
        $this->cpf = $cpf;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function setPassword($password){
        $this->password = $password;
    }
}
