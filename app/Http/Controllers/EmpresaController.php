<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Endereco;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index(){
        $empresa = new Empresa();
        $empresas = $empresa
        ->join('enderecos', 'empresas.endereco_id', '=', 'enderecos.id')
        ->get();
        return view('empresa.listar', compact('empresas'));
    }
    public function create(){
        $endereco = new Endereco();
        $enderecos = $endereco::all();
        return view('empresa.create', compact('enderecos'));
    }

    public function store(Request $request){

        $request->validate([
            'nomeEmpresa' => 'required',
            'email' => 'required|email',
            'cnpj' => 'required|cnpj',
            'endereco' => 'required',
        ]);

        $empresa = new Empresa();

        $empresa->nomeEmpresa = $request->input('nomeEmpresa');
        $empresa->email = $request->input('email');
        $empresa->cnpj = $request->input('cnpj');
        $empresa->endereco_id = $request->input('endereco');
        $empresa->usuario_id = '1';
        $salvar = $empresa->save();

        if($salvar){
            $status = "success";
            $msg = "Registro salvo com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }

        return view('empresa.create', ['msg' => $msg, 'status' => $status]);
    }

}
