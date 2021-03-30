<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioApiController extends Controller
{
    public function store(Request $request)
    {
        $endereco = new Endereco();
        $usuario = new Usuario();

        if ($request->id == '') {
            $this->validate($request, $usuario->rules());
            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');

            $salvar  = $endereco->save();

            if ($salvar) {
            $endereco  = DB::table('enderecos')->orderBy('id', 'desc')->first();

            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');
            $usuario->endereco_id = $endereco->id;

            $salvar  = $usuario->save();

                if ($salvar) {
                    $msg = "Registro salvo com sucesso!";
                    return response()->json(['message' => $msg], 201);
                }
            }
        } else {

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

            $salvar  = $endereco->save();

            $usuario  = Usuario::find($request->input('id'));
            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');
            $usuario->endereco_id = $request->input('idendereco');

            $update  = $usuario->update();
            $msg = "Atualização salva com sucesso!";
            if ($update) {
                return response()->json(['message' => $msg], 201);
            }
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
            return response()->json(['message' => $msg], 404);
        }

        if ($delete) {
            $msg = "Deleção realizada com sucesso!";
            return response()->json(['message' => $msg], 201);
        }
    }
}
