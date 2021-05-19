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
    public function getToken()
    {
        $gateway = new GatewayPagamento();

        //Essa credencial é utilizada para obter o token JWT
        $client_credentials = base64_encode($gateway->getClientId() . ":" . $gateway->getClientSecret());

        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/authorization-server/oauth/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Basic {$client_credentials}"
        ]);
        $token = json_decode(curl_exec($ch));
        $token = $token->access_token;
        return $token;
    }


}
