<?php

namespace Juninho\CarrinhosCompras\services;

use Exception;
use Juninho\CarrinhosCompras\PersonalAccessToken;

class PersonalAccessTokenService
{
    public function create($user_id, $user_email){
        $token = md5($user_email.date('Y-m-d H:i:s'));
        $access_token = new PersonalAccessToken();
        $access_token->initConnection();
        $access_token->setToken($token);
        $access_token->setUserId($user_id);
        $access_token->setExpiredAt(
            date('Y-m-d H:i:s', 
                strtotime(
                " +2 hours"
                )
            )
        );
        $saved = $access_token->save();
        if($saved){
            return $token;
        }else{
            throw new Exception("Não foi possível autenticar");
        }
        $access_token->closeConnection();
    }
}
