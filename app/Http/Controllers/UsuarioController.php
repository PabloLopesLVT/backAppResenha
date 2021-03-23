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
        $request->validate([
            'nome' => 'required',
            'sobrenome' => 'required',
            'email' => 'required|email',
            'cpf' => 'required|cpf',
            'tipo' => 'required',
        ]);

        $usuario = new Usuario();

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

        return view('endereco.create', ['msg' => $msg, 'status' => $status]);

    }
}
