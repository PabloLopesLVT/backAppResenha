<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayPagamento extends Model
{
    use HasFactory;

    //Private Token, na documentação ele se refere também como Token do recurso
    public function getPrivateToken(){
        $PRIVATE_TOKEN = '645840F8738AEA87152A8DE98C088B5C94FF71560781F078489E0235CA5E70C8';
        return $PRIVATE_TOKEN;
    }

    public function getClientId(){
        $CLIENT_ID = 'lidkj7gZuQvzAihS';
        return $CLIENT_ID;
    }

    public function getClientSecret(){
        $CLIENT_SECRET = '1w7212iKCs8(GM6N*G|T;QGOr=;xf1&m';
        return $CLIENT_SECRET;
    }

    public function getClient_Credentials(){
        $client_cledenctials = $this->getClientId(). ":" . $this->getClientSecret();
        return $client_cledenctials;
    }



}
