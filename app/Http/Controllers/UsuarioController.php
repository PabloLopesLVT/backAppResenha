<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){

        $usuario = new Usuario();
        $usuarios = $usuario::all();

        return view('usuario.listar', compact('usuarios'));

    }
    public function create(){
        return view('usuario.create');
    }

    public function store(Request $request){

        $usuario = new Usuario();

        if ($request->id == '') {
            $request->validate([
                'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email|unique:usuarios',
                'cpf' => 'required|cpf|unique:usuarios',
                'tipo' => 'required',
            ]);

            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');

            $salvar  = $usuario->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }else{

            $request->validate([
                'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email',
                'cpf' => 'required|cpf',
                'tipo' => 'required',
            ]);
            $usuario  = Usuario::find($request->input('id'));
            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');

            $update  = $usuario->update();

            if($update){
                $status = "success";
                $msg = "Atualização salva com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }


        return view('endereco.create', ['msg' => $msg, 'status' => $status]);

    }


    public function editar($id){
        $usuario = Usuario::find($id);

        return view('usuario.create', ['usuario' => $usuario]);
    }

    public function destroy($id)
    {

        $usuario = Usuario::find($id);

        try{
            $delete = $usuario->delete();

        }catch (\Illuminate\Database\QueryException $e) {

            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o usuário $usuario->nome porque há registros em dependência desse registro.";
            $status = "danger";
            $usuarios = Usuario::get();
            return view('usuario.listar', ['msg' => $msg, 'status' => $status], compact('usuarios'));

        }

        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }


        return view('empresa.create',  ['msg' => $msg, 'status' => $status]);
    }
}
