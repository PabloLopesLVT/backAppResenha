<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GatewayPagamentoController extends Controller
{
    public function teste()
    {

        //Private Token, na documentação ele se refere também como Token do recurso
        $PRIVATE_TOKEN = '645840F8738AEA87152A8DE98C088B5C94FF71560781F078489E0235CA5E70C8';
        $CLIENT_ID = 'lidkj7gZuQvzAihS';
        $CLIENT_SECRET = '1w7212iKCs8(GM6N*G|T;QGOr=;xf1&m';

        //Essa credencial é utilizada para obter o token JWT
        $client_credentials = base64_encode($CLIENT_ID . ":" . $CLIENT_SECRET);

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
        //var_dump($token->access_token);

        //Requisição para obter o saldo da conta
        //Tem que passar a versão da API, o token do recurso, e o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/balance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$PRIVATE_TOKEN}",
            "Authorization: Bearer {$token->access_token}"
        ]);
        //echo $token->access_token;
        $resultad = json_decode(curl_exec($ch));
        var_dump($resultad);
    }
}
