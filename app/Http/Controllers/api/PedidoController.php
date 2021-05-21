<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PedidoController extends Controller
{
    public function index()
    {
    }

    public function criarPedido(Request $request)
    {
        $uuid = Uuid::uuid4();
        $msg = "Pedido feito com sucesso!";
        foreach ($request->request as $req) {
            // this will check for array and check the array has 2 elements
            if (is_array($req) && is_array($req) == 2) {
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
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['message' => 'erro'], 400);
                }
            }
        }
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
