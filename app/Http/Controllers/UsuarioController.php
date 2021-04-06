<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(){

        $usuario = new Usuario();
        $usuarios = $usuario::all();
        $endereco = Endereco::find($usuario->endereco_id);
        return view('usuario.listar', compact('usuarios'));

    }
    public function create(){

        return view('usuario.create');
    }

    public function store(Request $request){

        $endereco = new Endereco();

        $usuario = new Usuario();

        if ($request->id == '') {
            $request->validate([
                'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email|unique:usuarios',
                'cpf' => 'required|cpf|unique:usuarios',
                'tipo' => 'required',
            ]);
            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');
            $endereco->observacoes = $request->input('observacoes');

            $salvar  = $endereco->save();

            if($salvar){

            $endereco  = DB::table('enderecos')->orderBy('id', 'desc')->first();

            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');
            $usuario->endereco_id = $endereco->id;

            $salvar  = $usuario->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }
        }else{

            $request->validate([
                'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email',
                'cpf' => 'required|cpf',
                'tipo' => 'required',
            ]);
            $endereco  = Endereco::find($request->input('idendereco'));
            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');
            $endereco->observacoes = $request->input('observacoes');

            $salvar  = $endereco->save();

            $usuario  = Usuario::find($request->input('id'));
            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');
            $usuario->endereco_id = $request->input('idendereco');

            $update  = $usuario->update();

            if($update){
                $status = "success";
                $msg = "Atualização salva com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }

            return view('usuario.create', ['msg' => $msg, 'status' => $status]);


    }


    public function editar($id){
        $usuario = Usuario::find($id);

        $endereco = Endereco::find($usuario->endereco_id);

        return view('usuario.create', ['usuario' => $usuario, 'endereco' => $endereco]);
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


        return view('usuario.create',  ['msg' => $msg, 'status' => $status]);
    }
}
