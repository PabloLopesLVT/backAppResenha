<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioApiController extends Controller
{
    public function store(Request $request){

        $usuario = new Usuario();

        if ($request->id == '') {
         $this->validate($request, $usuario->rules());

            $usuario->nome = $request->input('nome');
            $usuario->sobrenome = $request->input('sobrenome');
            $usuario->email = $request->input('email');
            $usuario->cpf = $request->input('cpf');
            $usuario->tipo = $request->input('tipo');
            $usuario->endereco_id = $request->input('endereco_id');
            $salvar  = $usuario->save();

            if($salvar){
                $msg = "Registro salvo com sucesso!";
                return response()->json(['message' => $msg], 201);
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
            $usuario->endereco_id = $request->input('endereco_id');

            $update  = $usuario->update();
            $msg = "Atualização salva com sucesso!";
            if($update){
                return response()->json(['message' => $msg], 201);
            }
        }

    }

    public function destroy($id)
    {

        $usuario = Usuario::find($id);

        try{
            $delete = $usuario->delete();

        }catch (\Illuminate\Database\QueryException $e) {

            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o usuário $usuario->nome porque há registros em dependência desse registro.";
            return response()->json(['message' => $msg], 404);

        }

        if($delete){
            $msg = "Deleção realizada com sucesso!";
            return response()->json(['message' => $msg], 201);
        }


        return view('empresa.create',  ['msg' => $msg, 'status' => $status]);
    }

}
