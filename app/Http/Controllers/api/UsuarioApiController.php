<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\UsuarioHasEndereco;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioApiController extends Controller
{
    public function store(Request $request)
    {
        try{
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

                $salvar  = $usuario->save();

                $usuSaved  = DB::table('usuarios')->orderBy('id', 'desc')->first();

                $UsuarioHasEndereco = new UsuarioHasEndereco();

                $UsuarioHasEndereco->usuario_id =  $usuSaved->id;
                $UsuarioHasEndereco->endereco_id =  $endereco->id;
                $salvar  = $UsuarioHasEndereco->save();

                if ($salvar) {
                    $msg = "Registro salvo com sucesso!";
                    return response()->json(['message' => $msg], 201);
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


                $update  = $usuario->update();

                $usuSaved  = DB::table('usuarios')->orderBy('id', 'desc')->first();

                $UsuarioHasEndereco = new UsuarioHasEndereco();

                $UsuarioHasEndereco->usuario_id =  $usuSaved->id;
                $UsuarioHasEndereco->endereco_id =  $endereco->id;
                $update  = $UsuarioHasEndereco->update();

                if ($update) {
                    return response()->json(['message' => "Atualização realizada com sucesso"], 201);
                }else{
                    return response()->json(['message' => "Atualização não realizada com sucesso"], 400);
                }
            }

        }catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'erro'], 400);
        }

    }

    public function editarUsuario(Request $request)
    {
        try{

            $usuario = new Usuario();

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

                if ($update) {
                    return response()->json(['message' => "Atualização realizada com sucesso"], 201);
                }else{
                    return response()->json(['message' => "Atualização não realizada com sucesso"], 400);
                }


        }catch (\Illuminate\Database\QueryException $e) {
            return response()->json($e, 400);
        }

    }

    public function destroy($id)
    {

        $usuario = Usuario::find($id);

        try {
            $delete = $usuario->delete();
        } catch (\Illuminate\Database\QueryException $e) {

            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o usuário $usuario->nome porque há registros em dependência desse registro.";
            return response()->json(['message' => $msg], 400);
        }

        if ($delete) {
            $msg = "Deleção realizada com sucesso!";
            return response()->json(['message' => $msg], 201);
        }
    }
}
