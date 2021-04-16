<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Endereco;
use App\Models\UsuarioHasEndereco;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    public function editarEndereco(Request $request)
    {

        try {

            $usuariohasendereco = DB::table('usuarios_has_enderecos')
                ->where('usuario_id', $request->input('usuario_id'))
                ->where('endereco_id', $request->input('endereco_id'))
                ->get();

            $request->validate([
                'logradouro' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'municipio' => 'required',
                'estado' => 'required',
                'cep' => 'required',
                'complemento' => 'required',
            ]);
            $endereco = new Endereco();


            $endereco  = Endereco::find($usuariohasendereco[0]->id);
            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');

            $update  = $endereco->update();

            if ($update) {
                return response()->json(['message' => "Atualização realizada com sucesso"], 201);
            } else {
                return response()->json(['message' => "Atualização não realizada com sucesso"], 400);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([$e], 400);
        }
    }

    public function createEndereco(Request $request)
    {

        try {


            $request->validate([
                'logradouro' => 'required',
                'numero' => 'required',
                'bairro' => 'required',
                'municipio' => 'required',
                'estado' => 'required',
                'cep' => 'required',
                'complemento' => 'required',
            ]);
            $endereco = new Endereco();

            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');

            $update  = $endereco->save();
            $endereco  = DB::table('enderecos')->orderBy('id', 'desc')->first();
            $UsuarioHasEndereco = new UsuarioHasEndereco();

            $UsuarioHasEndereco->usuario_id =  $request->input('usuario_id');
            $UsuarioHasEndereco->endereco_id =  $endereco->id;
            $salvar  = $UsuarioHasEndereco->save();

            if ($salvar) {
                return response()->json(['message' => "Atualização realizada com sucesso"], 201);
            } else {
                return response()->json(['message' => "Atualização não realizada com sucesso"], 400);
            }


        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([$e], 400);
        }
    }

    public function destroy($usuario_id, $endereco_id){

        try{
            $usuariohasendereco = DB::table('usuarios_has_enderecos')
            ->where('usuario_id', $usuario_id)
            ->where('endereco_id', $endereco_id)
            ->delete();

            $deleteEnd  = Endereco::find($endereco_id);
            $deleteEnd->delete();
        }catch (\Illuminate\Database\QueryException $e) {
            return response()->json([$e], 400);
        }
        return response()->json(['message' => "Deleção realizada com sucesso"], 201);

    }
}
