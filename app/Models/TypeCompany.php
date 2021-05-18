<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCompany extends Model
{
    use HasFactory;

    protected $fillable = [
      "companyTypes"
    ];

    public function getTypeCompany()
    {
        $gateway = new GatewayPagamento();

        /*
         * O Company Type é um campo essencial na hora de criar
         * empresas.
         * Link da Documentação: https://dev.juno.com.br/api/v2#operation/getCompanyTypes
         */

        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/data/company-types");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8", // Cabeçalho da Requisição
            "X-Api-Version:  2", // Versão da API
            "X-Resource-Token:  {$gateway->getPrivateToken()}",
            "Authorization: Bearer {$gateway->getToken()}"
        ]);

        $typeCompany = json_decode(curl_exec($ch));
        return response()->json(['dados' =>  $typeCompany], 201);
    }
}
