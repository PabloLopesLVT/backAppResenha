<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessArea extends Model
{
    use HasFactory;

    protected $fillable = [
      "code",
      "activity",
      "category"
    ];

    public function getBusinessArea()
    {
        $gateway = new GatewayPagamento();

        /*
         * A Business Area busca as áreas de atuações das empresas
         * o campo é necessário na criação da conta digital.
         * Link da documentação: https://dev.juno.com.br/api/v2#operation/getCompanyTypes
         */

        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/data/business-areas");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8", // Cabeçalho da Requisição
            "X-Api-Version:  2", // Versão da API
            "X-Resource-Token:  {$gateway->getPrivateToken()}",
            "Authorization: Bearer {$gateway->getToken()}"
        ]);

        $businessAreas = json_decode(curl_exec($ch));
        return response()->json(['dados' =>  $businessAreas], 201);

    }
}
