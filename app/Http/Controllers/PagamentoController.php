<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\GatewayPagamento;
use App\Models\TokenCartao;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagamentoController extends Controller
{
    function __construct()
    {
        $this->setToken(env('TOKEN_JUNO'));
    }
    public function limparCaracteres($valor)
    {
        $valor = preg_replace('/[^0-9]/', '', $valor);
        return $valor;
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
      //  dd($data);
        $data = json_encode($data);


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

        if(!isset($ch->status)){
            $token = new TokenCartao();
            $usuario = DB::table('usuarios')->where('id', $request->input('usuario_id'))->get();

            $token->usuario_id = $usuario[0]->id;
            $token->creditCardId = $ch->creditCardId;
            $token->last4CardNumber = $ch->last4CardNumber;
            $token->expirationMonth = $ch->expirationMonth;
            $token->expirationYear = $ch->expirationYear;
            $token->save();
            return response()->json(['message'=> "Token do cartão criado com sucesso!"], 200);
        }else{
            return response()->json(['message'=> $ch], 404);
        }
    }

    public function efetuarPagamento(Request $request)
    {
        $gateway = new GatewayPagamento();
        $usuario = Usuario::find($request->input('usuario_id'));
        $enderecohasusuario = DB::table('usuarios_has_enderecos')->where('usuario_id', $usuario->id)->get();
        $endereco = Endereco::find($enderecohasusuario[0]->endereco_id);
        $tokenCartao = DB::table('token_cartoes')->where('usuario_id',$usuario->id)->get();

        $data = array(
            "chargeId" => $request->input('chargeId'),
            "billing" => array(
                "email" => $usuario->email,
                "address" => array(
                    "street" => $endereco->logradouro,
                    "number" => $endereco->numero,
                    "complement" => $endereco->complemento,
                    "neighborhood" => $endereco->bairro,
                    "city" => $endereco->municipio,
                    "state" => $endereco->estado,
                    "postCode" => $this->limparCaracteres($endereco->cep)
                ),
                "delayed" => false // Caso esse valor esteja TRUE o valor será reservado mas não será cobrado (ótimo para prestação de serviços)
            ),
            "creditCardDetails" => array(
                "creditCardId" => $tokenCartao[0]->creditCardId,
                // "creditCardHash" => "1c9f128a-fae6-4af8-9017-ac2df02e4c64" // Pode ser o creditCardId ou creditCardHash

            )
        );
        $data = json_encode($data);
        // var_dump($data);

        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/payments");
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
        if(!isset($ch->status)){
            return response()->json(['message'=> "Pagamento efetuado com sucesso!"], 200);
        }else{
            return response()->json(['message'=> $ch], 404);
        }
      dd($ch);
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
