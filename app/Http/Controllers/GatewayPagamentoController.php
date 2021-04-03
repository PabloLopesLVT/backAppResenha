<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GatewayPagamento;

class GatewayPagamentoController extends Controller
{
    //Private Token, na documentação ele se refere também como Token do recurso

    public function teste()
    {
        $this->saldo();
        $this->cobranca();
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

    public function saldo(){
        //Balance
        $gateway = new GatewayPagamento();

        //Requisição para obter o saldo da conta
        //Tem que passar a versão da API, o token do recurso, e o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/balance");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$gateway->getPrivateToken()}",
            "Authorization: Bearer {$this->getToken()}"
        ]);
        //echo $token->access_token;
        $resultad = json_decode(curl_exec($ch));
        var_dump($resultad);

    }

    public function cobranca(){
        $gateway = new GatewayPagamento();

        //Essa credencial é utilizada para obter o token JWT
        $client_credentials = base64_encode($gateway->getClientId() . ":" . $gateway->getClientSecret());

        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/charges");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "Content-Type: application/json;charset=UTF-8",
            "pixKey: TESTE"
        ]);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$gateway->getPrivateToken()}",
            "Authorization: Bearer {$this->getToken()}"
        ]);
        $cobranca = json_decode(curl_exec($ch));
        echo '<pre>';
        var_dump($cobranca);
        echo '</pre>';

    }
}
