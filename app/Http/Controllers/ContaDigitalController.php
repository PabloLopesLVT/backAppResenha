<?php

namespace App\Http\Controllers;

use App\Models\GatewayPagamento;
use Illuminate\Http\Request;

class ContaDigitalController extends Controller
{

    public function criarContaDigital()
    {
        $gateway = new GatewayPagamento();
        $data = array(
            "type" => "PAYMENT",
            "name" => "Whentony Soares Ferreira",
            "document" => "37477440874",
            "email" => "whentony.ferreira@gmail.com",
            "birthDate" => "1989-11-06",
            "phone" => "33988185976",
            "businessArea" => 1001, // Tem que acessar a API para ver os códigos
            "motherName" => "Maria Rosa",
            "linesOfBusiness" => "Ainda não sei",
            //   "companyType" => "MEI",
            "legalRepresentative" => array(
                "name" => "Whentony Soares Ferreira",
                "document" => "37477440874",
                "birthDate" => "1968-11-06",

                "type" => "INDIVIDUAL"
            ),
            "address" => array(
                "street" => "Rua Dr Mata Machado",
                "number" => "368",
                "complement" => "string",
                "neighborhood" => "string",
                "city" => "São João Evangelista",
                "state" => "MG",
                "postCode" => "39705000"
            ),
            "bankAccount" => array(
                "bankNumber" => "001",
                "agencyNumber" => "56626",
                "accountNumber" => "5430-5",
                "accountType" => "CHECKING",
                "accountHolder" => array(
                    "name" => "Whentony Soares Ferreira",
                    "document" => "37477440874"
                ),

            ),
            // "emailOptOut" => false,
            //  "autoTransfer" => false,
            //   "socialName" => false,
            "monthlyIncomeOrRevenue" => 10000,
            //   "cnae" => "strings",
            //  "establishmentDate" => "2021-04-07",
            //    "pep" => false,
            //   "companyMembers" => array(
            //      "name" => "string",
            //       "document" => null,
            //       "birthDate" => "2021-01-07"
            //   )
        );

        $data = json_encode($data);
        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/digital-accounts");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$gateway->getPrivateToken()}",
            "Authorization: Bearer {$this->getToken()}",

        ]);
        $criarconta = json_decode(curl_exec($ch));
        var_dump($criarconta);
        return $criarconta;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
