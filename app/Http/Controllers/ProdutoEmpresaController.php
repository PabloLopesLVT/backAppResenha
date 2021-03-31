<?php

namespace App\Http\Controllers;

use App\Models\ProdutoEmpresa;
use Illuminate\Http\Request;

class ProdutoEmpresaController extends Controller
{
    public function index(){
        $produto = new ProdutoEmpresa();
        $produtos = $produto::all();

        return view('produtoEmpresa.listar', compact('produtos'));

    }

    public function create(){
        return view('produtoEmpresa.create');
    }

    public function editar($id){
        $produto = ProdutoEmpresa::find($id);
        return view('produtoEmpresa.create', ['produto' => $produto]);
    }

    public function store(Request $request){
        $status = "";
        $msg = "";

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

        return view('produtoEmpresa.create', ['msg' => $msg, 'status' => $status]);
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
