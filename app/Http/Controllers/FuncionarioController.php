<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Endereco;
use App\Models\Funcionario;

class FuncionarioController extends Controller
{
    public function index(){

        $funcionario = new Funcionario();
        $funcionarios = $funcionario::all();

        return view('funcionario.listar', compact('funcionarios'));

    }
    public function create(){
        $empresa = new Empresa();
        $empresas = $empresa::all();
        return view('funcionario.create', compact('empresas'));
    }

    public function store(Request $request){

        $endereco = new Endereco();

        $funcionario = new Funcionario();

        if ($request->id == '') {
            $request->validate([
                'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email|unique:funcionarios',
                'cpf' => 'required|cpf|unique:funcionarios',
                'funcao' => 'required',
                'empresa' => 'required'
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

            $funcionario->nome = $request->input('nome');
            $funcionario->sobrenome = $request->input('sobrenome');
            $funcionario->email = $request->input('email');
            $funcionario->cpf = $request->input('cpf');
            $funcionario->funcao = $request->input('funcao');
            $funcionario->endereco_id = $endereco->id;
            $funcionario->empresa_id = $request->input('empresa');
            $salvar  = $funcionario->save();

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
                'funcao' => 'required',
                'empresa' => 'required',
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

            $funcionario  = Funcionario::find($request->input('id'));
            $funcionario->nome = $request->input('nome');
            $funcionario->sobrenome = $request->input('sobrenome');
            $funcionario->email = $request->input('email');
            $funcionario->cpf = $request->input('cpf');
            $funcionario->funcao = $request->input('funcao');
            $funcionario->endereco_id = $request->input('idendereco');
            $funcionario->empresa_id = $request->input('empresa');

            $update  = $funcionario->update();

            if($update){
                $status = "success";
                $msg = "Atualização salva com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }

            return view('funcionario.create', ['msg' => $msg, 'status' => $status]);


    }


    public function editar($id){
        $funcionario = Funcionario::find($id);

        $endereco = Endereco::find($funcionario->endereco_id);
        $empresa = new Empresa();
        $empresas = $empresa::all();
        return view('funcionario.create', compact('empresas'), ['funcionario' => $funcionario, 'endereco' => $endereco]);
    }

    public function destroy($id)
    {

        $usuario = Funcionario::find($id);

        try{
            $delete = $usuario->delete();

        }catch (\Illuminate\Database\QueryException $e) {

            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o usuário $usuario->nome porque há registros em dependência desse registro.";
            $status = "danger";
            $funcionarios = Funcionario::get();
            return view('funcionario.listar', ['msg' => $msg, 'status' => $status], compact('funcionarios'));

        }

        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }
        $empresa = new Empresa();
        $empresas = $empresa::all();

        return view('funcionario.create', compact('empresas'),  ['msg' => $msg, 'status' => $status]);
    }
}
