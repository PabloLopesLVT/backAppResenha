<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{



    public function cropimage(){
        $produto = new Produto();
        $produtos = $produto::all();

        return view('produto.listar', compact('produtos'));

    }
    public function index(){
        $produto = new Produto();
        $produtos = $produto::all();

        return view('produto.listar', compact('produtos'));

    }

    public function create(){
        return view('produto.create');
    }

    public function editar($id){
        $produto = Produto::find($id);
        return view('produto.create', ['produto' => $produto]);
    }

    public function store(Request $request){
        $status = "";
        $msg = "";
        $nameFile = "";
        $produto = new Produto();
        if ($request->id == '') {

            $this->validate($request, $produto->rules());


       /*     if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
                $extension = $request->imagem->extension();

                $name = uniqid(date('His'));

                $nameFile = "{$name}.{$extension}";
                $upload  = Image::make($request->file('imagem'))->resize(200, 200)->save(storage_path("app/public/produtos/$nameFile", 70));

                if(!$upload){
                    return view('produto.create', ['msg' => "Falha ao fazer upload da imagem", 'status' => 'danger']);
                }

            }*/
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

            if($request->hasFile('imagem') && $request->file('imagem')->isValid()){
                $extension = $request->imagem->extension();

                $name = uniqid(date('His'));

                $nameFile = "{$name}.{$extension}";
                $upload  = Image::make($request->file('imagem'))->resize(200, 200)->save(storage_path("app/public/produtos/$nameFile", 70));

                if(!$upload){
                    return view('produto.create', ['msg' => "Falha ao fazer upload da imagem", 'status' => 'danger']);
                }

            }
            $produto  = Produto::find($request->input('id'));
            $produto->nome = $request->input('nome');
            $produto->marca = $request->input('marca');
            $produto->status = $request->input('status');
            $produto->imagem = $nameFile;
            $update = $produto->update();
            if($update){
                $status = "success";
                $msg = "Atualização realizada com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve um erro na atualização dos dados!";
            }
     }

        return view('produto.create', ['msg' => $msg, 'status' => $status]);
    }

    public function destroy($id){
        $produto = Produto::find($id);

        try{
            $delete = $produto->delete();
        }catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o registro $produto->razaosocial porque há registro em dependência desse registro.";
            $status = "danger";
            $produtos = Produto::get();
            return view('produto.listar', ['msg' => $msg, 'status' => $status], compact('produtos'));

        }
        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }


        return view('produto.create', ['msg' => $msg, 'status' => $status]);
    }
}
