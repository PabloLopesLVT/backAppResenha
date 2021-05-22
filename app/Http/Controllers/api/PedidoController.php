<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\GatewayPagamento;
use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PedidoController extends Controller
{
    public function limparCaracteres($valor)
    {
        $valor = preg_replace('/[^0-9]/', '', $valor);
        return $valor;
    }

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

    public function index()
    {
    }

    public function criarPedido(Request $request)
    {

        $gateway = new GatewayPagamento();
        $uuid = Uuid::uuid4();
        $msg = "Pedido feito com sucesso!";
        $valorTotaldoPedido = 0; // Valor total do pedido
        foreach ($request->request as $req) {

            $pedido = new Pedido();
            try {
                $pedido->produto_empresa_id = $req['produto_empresa_id'];
                $pedido->empresa_id = $req['empresa_id'];
                $pedido->usuario_id = $req['usuario_id'];
                $pedido->valor = $req['valor'];
                $pedido->status = $req['status'];
                $pedido->quantidade = $req['quantidade'];
                $pedido->identificacao_pedido = $uuid;
                $pedido->save();
                $usuario = $req['usuario_id'];
                $contaDigital = DB::table('conta_digitais')->where('empresa_id', $req['empresa_id'])->get();

                $subtotal = $req['valor'] * $req['quantidade'];
                $s[] = array(

                        "recipientToken" => $contaDigital[0]->resourceToken,
                        "amount" => $subtotal ,
                        "amountRemainder" => false,
                        "chargeFee" => true

                    );

                $valorTotaldoPedido = $valorTotaldoPedido + $subtotal;

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['message' => 'erro'], 400);
            }

        }
        //Juno com a conta oficil do dono do app
        //Inserindo o token dele para ele pegar a fatia
        $s[] = array(
            "recipientToken" => $this->getToken(),
            "amount" => 6,
            "amountRemainder" => true,
            "chargeFee" => true
        );
        //---------------------------------------
       // var_dump($s);
        $charge = array(
            "charge" => array(
                //  "pixKey" => $cob->getPixkye(),
                "description" => $pedido->produto_empresa_id,
                /*  "references" => array(
                      "teste", "teste", //Isso aqui tem que ser igual ao número de parcelas
                  ),*/
                "totalAmount" => $valorTotaldoPedido,
                // "dueDate" => $cob->getDueDate(), //Data de Pagamento
                "installments" => 1, //Número de parcelas
                //    "maxOverdueDays" => $cob->getMaxOverdueDays(),
                //   "fine" => $cob->getFine(), //Multa para pagamento após o vencimento
                //   "interest" => $cob->getInterest(),
                //   "discountAmount" => $cob->getDiscountAmount(),
                //   "discountDays" => $cob->getDiscountDays(),
                "paymentTypes" => array(
                    "CREDIT_CARD"
                ),
                //    "paymentAdvance" => $cob->getPaymentAdvance(),
                //   "feeSchemaToken" => $cob->getFeeSchemaToken(),
                "split" => $s,
            ),
        );
      //  dd($s);

        $usuario = Usuario::find($usuario);
        $enderecohasusuario = DB::table('usuarios_has_enderecos')->where('usuario_id', $usuario->id)->get();

        $endereco = Endereco::find($enderecohasusuario[0]->endereco_id);

        $billing = array(
            "billing" => array(
                "name" =>$usuario->nome ." ". $usuario->sobrenome,
                "document" => $this->limparCaracteres($usuario->cpf),
                "email" => $usuario->email,
                "address" => array(
                    "street" => $endereco->logradouro,
                    "number" => $endereco->numero,
                    "complement" => $endereco->complemento,
                    "neighborhood" => $endereco->bairro,
                    "city" => $endereco->municipio,
                    "state" => $endereco->estado,
                    "postCode" => $this->limparCaracteres($endereco->cep),
                ),
                "notify" => "false" // Receber email da juno sobre a compra
            )
        );
        $data = array_merge($charge, $billing);
       // dd($data);
        $data = json_encode($data);

        //Requisição para obter o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/charges");
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
        $cobranca = json_decode(curl_exec($ch));
        dd($cobranca);
        return response()->json(['message' => $msg], 201);
    }

    public function pedidoAberto($usuario_id)
    {
        $pedido = new Pedido();


        $pedido = $pedido::where('usuario_id', $usuario_id)
            ->where('status', 1)->get();

        return response()->json(['dados' => $pedido], 201);
    }

    /*public function pedidoAlterarStatus(Request $request){
        $pedido = new Pedido();

        $idPedido = $request->input('id');
        $pedido = $pedido::where('usuario_id', $usuario_id)
                            ->where('status', 1)->get();

        return response()->json(['dados' => $pedido], 201);

    }*/
}
