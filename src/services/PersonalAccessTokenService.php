<?php

namespace App\services;

use Exception;
use App\PersonalAccessToken;

class PersonalAccessTokenService
{
    public function create($user_id, $user_email){
        $token = md5($user_email.date('Y-m-d H:i:s'));
        $access_token = new PersonalAccessToken();
        $access_token->initConnection();
        $access_token->setToken($token);
        $access_token->setUserId($user_id);
        $access_token->setExpiredAt(
            $this->getExpiredAt()
        );
        $saved = $access_token->save();
        if($saved){
            return $token;
        }else{
            throw new Exception("Não foi possível autenticar");
        }
        $access_token->closeConnection();
    }

    protected function getExpiredAt(){
        $expired_at = null;
        $expired_at = date('Y-m-d H:i:s', 
        strtotime(
             date('Y-m-d H:i:s').
        " +120 minutes"
        )
        );
        return $expired_at;
    }
}
