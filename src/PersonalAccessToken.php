<?php

namespace App;

class PersonalAccessToken extends Model
{
    protected $token;
    protected $user_id;
    protected $expired_at;
    protected $created_at;
    protected $table = 'personal_access_token';
    protected $fillable = ["token", "user_id", "expired_at"];
    protected $accessible = ["token", "user_id", "expired_at", 'id'];

    public function getToken(){
        return $this->token;
    }
    public function getUserId(){
        return $this->user_id;
    }
    public function getExpiredAt(){
        return $this->expired_at;
    }
    public function getCreatedAt(){
        return $this->created_at;
    }
    public function setToken($token){
        $this->token = $token;
    }
    public function setUserId($user_id){
        $this->user_id = $user_id;
    }
    public function setExpiredAt($expired_at){
        $this->expired_at = $expired_at;
    }
    public function setCreatedat($created_at){
        $this->created_at = $created_at;
    }
}
