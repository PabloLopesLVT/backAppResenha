<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{

    public function status($id, $status){
        $produto = Produto::find($id);

        $produto->status = $status;
        $update = $produto->update();
        if($update){
            $msg =  "Status Alterado com Sucesso";
        }else{
            $msg =  "Status não foi alterado com Sucesso";
        }
        return $msg;
    }


    public function index(){
        $produtos = DB::table('produtos AS p')
        ->select('p.id AS idproduto', 'p.nome as nomeproduto', 'p.imagem', 'p.marca', 'p.status', 'categoria_produtos.nome')
        ->join('categoria_produtos', 'p.categoria_produto_id', '=', 'categoria_produtos.id')
        ->get();
        return view('produto.listar', compact('produtos'));

    }

    public function create(){
        $categorias = CategoriaProduto::all();
        return view('produto.create', compact('categorias'));
    }

    public function editar($id){
        $produto = Produto::find($id);
        $categorias = CategoriaProduto::all();
        return view('produto.create', compact('categorias'), ['produto' => $produto]);
    }

    public function store(Request $request){
        $status = "";
        $msg = "";
        $nameFile = "";
        $produto = new Produto();
        if ($request->id == '') {

            $this->validate($request, $produto->rules());

            $folderPath = storage_path('/app/public/produtos/');

            $image_parts = explode(";base64,", $request->imagem);

            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $imageName = uniqid() . '.png';

            $imageFullPath = $folderPath.$imageName;

            file_put_contents($imageFullPath, $image_base64);

            $produto->nome = $request->input('nome');
            $produto->marca = $request->input('marca');
            $produto->status = $request->input('status');
            $produto->categoria_produto_id = $request->input('categoria');
            $produto->imagem = $imageName;

            $salvar  = $produto->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }

        }else{

            $folderPath = storage_path('/app/public/produtos/');

            $image_parts = explode(";base64,", $request->imagem);

            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            $imageName = uniqid() . '.png';

            $imageFullPath = $folderPath.$imageName;

            file_put_contents($imageFullPath, $image_base64);

            $produto  = Produto::find($request->input('id'));
            $produto->nome = $request->input('nome');
            $produto->marca = $request->input('marca');
            $produto->status = $request->input('status');
            $produto->imagem = $imageName;
            $produto->categoria_produto_id = $request->input('categoria');
            $update = $produto->update();
            if($update){
                $status = "success";
                $msg = "Atualização realizada com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve um erro na atualização dos dados!";
            }
     }

     $produtos = DB::table('produtos AS p')
        ->select('p.id AS idproduto', 'p.nome as nomeproduto', 'p.imagem', 'p.marca', 'p.status', 'categoria_produtos.nome')
        ->join('categoria_produtos', 'p.categoria_produto_id', '=', 'categoria_produtos.id')
        ->get();
        return view('produto.listar', compact('produtos'), ['msg' => $msg, 'status' => $status]);
    }

    public function destroy($id){
        $produto = Produto::find($id);

        try{
            $delete = $produto->delete();
        }catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o registro $produto->razaosocial porque há registro em dependência desse registro.";
            $status = "danger";
            $produtos = DB::table('produtos AS p')
            ->select('p.id AS idproduto', 'p.nome as nomeproduto', 'p.imagem', 'p.marca', 'p.status', 'categoria_produtos.nome')
            ->join('categoria_produtos', 'p.categoria_produto_id', '=', 'categoria_produtos.id')
            ->get();
            return view('produto.listar', ['msg' => $msg, 'status' => $status], compact('produtos'));

        }
        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }

        $produtos = DB::table('produtos AS p')
        ->select('p.id AS idproduto', 'p.nome as nomeproduto', 'p.imagem', 'p.marca', 'p.status', 'categoria_produtos.nome')
        ->join('categoria_produtos', 'p.categoria_produto_id', '=', 'categoria_produtos.id')
        ->get();
        return view('produto.listar', compact('produtos'), ['msg' => $msg, 'status' => $status]);
    }
}
