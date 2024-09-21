<?php

namespace App\services;

use App\http\Controllers\AuthController;
use Exception;
use App\PersonalAccessToken;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class PersonalAccessTokenService
{
    public function create($user_id){
        $tokens_user = new AuthService();
        $tokens_user->deleteOldTokens($user_id);
        $token = Uuid::uuid4();
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
        return Carbon::now()->add(120,"minute");
    }

    
}
