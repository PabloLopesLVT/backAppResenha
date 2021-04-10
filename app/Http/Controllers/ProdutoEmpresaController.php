<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\ProdutoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;

class ProdutoEmpresaController extends Controller
{
    public function index(){
        $produtoEmpresas = DB::table('produtos_empresas')
            ->join('produtos', 'produtos_empresas.produto_id', '=', 'produtos.id')
            ->select('produtos_empresas.id as idpe',
                    'produtos.nome',
                    'produtos_empresas.valor1',
                    'produtos_empresas.valor2',
                    'produtos_empresas.quantidade',
                    )
            ->get();

        return view('produtoEmpresa.listar', compact('produtoEmpresas'));

    }

    public function create(){
        $produtos = Produto::all();
        $user = DB::table('users')->where('id', Auth::id())->get();

        $empresa = Empresa::find($user[0]->empresa_id);
        return view('produtoEmpresa.create', compact('produtos'), ['empresa' => $empresa]);
    }

    public function editar($id){
        $produto = ProdutoEmpresa::find($id);
        return view('produtoEmpresa.create', ['produto' => $produto]);
    }
    public function checarStatus($id){
        $produto = DB::table('produtos_empresas')
        ->where('produto_id', $id)
        ->get();

        return response()->json(['message' => $produto->count(), 'id' => $id], 201);

    }

    public function store(Request $request){
        $status = "";
        $msg = "";
        try{
        $produto = new ProdutoEmpresa();
        if ($request->id == '') {

            $this->validate($request, $produto->rules());

            $produto->quantidade = $request->input('quantidade');
            $produto->valor1 = $request->input('valor1');
            $produto->valor2 = $request->input('valor2');
            $produto->produto_id = $request->input('produto_id');
            $produto->empresa_id = $request->input('empresa_id');

            $salvar  = $produto->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }

        }else{
            $produto  = ProdutoEmpresa::find($request->input('id'));
            $produto->quantidade = $request->input('quantidade');
            $produto->valor1 = $request->input('valor1');
            $produto->valor2 = $request->input('valor2');
            $produto->produto_id = $request->input('produto_id');
            $produto->empresa_id = $request->input('empresa_id');

            $update = $produto->update();
            if($update){
                $status = "success";
                $msg = "Atualização realizada com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve um erro na atualização dos dados!";
            }
     }
    }catch (\Illuminate\Database\QueryException $e) {
        return response()->json(['message' => $e], 201);
    }
     return response()->json(['message' => $msg], 201);
    }

    public function destroy($id){
        $produto = ProdutoEmpresa::find($id);

        try{
            $delete = $produto->delete();
        }catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o registro $produto->razaosocial porque há registro em dependência desse registro.";
            $status = "danger";
            $produtos = ProdutoEmpresa::get();
            return view('produtoEmpresa.listar', ['msg' => $msg, 'status' => $status], compact('produtos'));

        }
        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }


        return view('produtoEmpresa.create', ['msg' => $msg, 'status' => $status]);
    }
}
