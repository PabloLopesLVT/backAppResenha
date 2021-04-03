<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index(){
        $empresa = new Empresa();
        $empresas = DB::table('empresas AS e')
        ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
        ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
        ->get();

        return view('empresa.listar', compact('empresas'));
    }
    public function create(){
        $endereco = new Endereco();
        $enderecos = $endereco::all();
        return view('empresa.create', compact('enderecos'));
    }

    public function editar($id){
        $empresa = Empresa::find($id);
        $endereco = Endereco::find($empresa->endereco_id);

        return view('empresa.create', ['empresa' => $empresa, 'endereco' => $endereco]);
    }

    public function store(Request $request){

        $empresa = new Empresa();
        $status = "";
        $msg = "";
        $endereco = new Endereco();
        $enderecos = $endereco::all();

        if ($request->id == '') {

            $request->validate([
                'nomeEmpresa' => 'required',
                'email' => 'required|email|unique:empresas',
                'cnpj' => 'required|cnpj|unique:empresas',
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
            $empresa->nomeEmpresa = $request->input('nomeEmpresa');
            $empresa->email = $request->input('email');
            $empresa->celular = $request->input('telefone');
            $empresa->razaoSocial = $request->input('razaoSocial');
            $empresa->responsavel = $request->input('responsavel');
            $empresa->cnpj = $request->input('cnpj');
            $empresa->endereco_id = $endereco->id;

            $salvar = $empresa->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }
        }else{
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

            $empresa  = Empresa::find($request->input('id'));
            $empresa->nomeEmpresa = $request->input('nomeEmpresa');
            $empresa->email = $request->input('email');
            $empresa->celular = $request->input('telefone');
            $empresa->razaoSocial = $request->input('razaoSocial');
            $empresa->responsavel = $request->input('responsavel');
            $empresa->cnpj = $request->input('cnpj');
            $empresa->endereco_id = $request->input('idendereco');

            $update = $empresa->update();
            if($update){
                $status = "success";
                $msg = "Atualização realizada com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve um erro na atualização dos dados!";
            }
     }

        return view('empresa.create', ['msg' => $msg, 'status' => $status]);
    }

    public function destroy($id)
    {
        $empresa = Empresa::find($id);

        try{
            $delete = $empresa->delete();
        }catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o empresa $empresa->razaosocial porque há usuários em dependência desse registro.";
            $status = "danger";
            $empresas = Empresa::get();
            return view('empresa.listar', ['msg' => $msg, 'status' => $status], compact('empresas'));

        }
        if($delete){
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }
        $endereco = new Endereco();
        $enderecos = $endereco::all();

        return view('empresa.create', compact('enderecos'), ['msg' => $msg, 'status' => $status]);
    }
}
