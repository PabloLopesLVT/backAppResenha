<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function login(Request $request){

        $credenciais = request(['email', 'password']);
        if(!Auth::attempt($credenciais)){
            $erro = "Não autorizado";
            $resposta = [
                'error' => $erro,
            ];
            return response()->json($resposta, 404);
        }

        $usuario = $request->user();
        $resposta['name'] = $usuario->name;
        $resposta['email'] = $usuario->email;
        $resposta['token'] = $usuario->createToken('token')->accessToken;

        return response()->json($resposta, 200);
    }

    public  function logout(Request $request){
        $isUser = $request->user()->token()->revoke();
        if($isUser){
            $resposta['message'] = "Logout efetuado com sucesso.";
            return response()->json($resposta, 200);
        }else{
            $resposta = "Algo deu errado.";
            return response()->json($resposta, 404);
        }

    }
}
