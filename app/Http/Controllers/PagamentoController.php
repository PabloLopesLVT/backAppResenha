<?php

namespace App\Http\Controllers;

use App\Models\GatewayPagamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    function __construct()
    {
        $this->setToken(env('TOKEN_JUNO'));
    }

    private $token;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }
    public function tokenizar(Request $request){

        $gateway = new GatewayPagamento();

        $data = array(
            "creditCardHash" =>  $request->input('creditCardHash')
        );
        $data = json_encode($data);

        dd( $request->input('creditCardHash'));
        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/credit-cards/tokenization");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$this->getToken()}",
            "Authorization: Bearer {$gateway->getToken()}",

        ]);
        $ch = json_decode(curl_exec($ch));
        if (isset($ch->error)) {
            $cobranca = array(
                'timestamp' => $ch->timestamp,
                'status' => $ch->status,
                'error' => $ch->error
            );
        } else {
            var_dump($ch);


            // $cobranca = json_encode($cobranca->_embedded->charges[0]);


        }
        dd($ch);
        return $ch;
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
