<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProduto;
use Illuminate\Http\Request;

class CategoriaProdutoController extends Controller
{

   public function index(){
       $categorias = CategoriaProduto::all();

       return view ('categoria.listar', compact('categorias'));
   }

   public function editar($id){
    $categoria = CategoriaProduto::find($id);
    return view('categoria.create', ['categoria' => $categoria]);
}

   public function create(){
        return view('categoria.create');
   }

   public function store(Request $request){
    $categoria = new CategoriaProduto();
    $status = "";
    $msg = "";
    if ($request->id == '') {
        $this->validate($request, $categoria->rules());

        $categoria->nome = $request->input('nome');
        $categoria->icone = $request->input('icone');
        $salvar  = $categoria->save();

        if($salvar){
            $status = "success";
            $msg = "Registro salvo com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }
    }else{
        $categoria = CategoriaProduto::find($request->input('id'));
        $categoria->nome = $request->input('nome');
        $categoria->icone = $request->input('icone');
        $update  = $categoria->update();

        if($update){
            $status = "success";
            $msg = "Atualização salva com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }
    }
    $categorias = CategoriaProduto::all();
    return view('categoria.listar', compact('categorias'), ['msg' => $msg, 'status' => $status]);
   }
   public function destroy($id)
   {

       $categoria = CategoriaProduto::find($id);

       try{
           $delete = $categoria->delete();

       }catch (\Illuminate\Database\QueryException $e) {

           //Tenho que ver pra onde vou mandar o cara quando ele deletar
           $msg = "Você não pode excluir esse registro porque há registros em dependência desse registro.";
           $status = "danger";
           $categorias = CategoriaProduto::get();
           return view('cadastro.listar', ['msg' => $msg, 'status' => $status], compact('categorias'));

       }

       if($delete){
           $status = "success";
           $msg = "Deleção realizada com sucesso!";
       }else{
           $status = "danger";
           $msg = "Houve um erro na atualização dos dados!";
       }
       $categorias = CategoriaProduto::get();

       return view('categoria.listar',  ['msg' => $msg, 'status' => $status], compact('categorias'));
   }

}
