<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index(){

        $endereco = new Endereco();
        $enderecos = $endereco::all();
        return view('endereco.listar', compact('enderecos'));
    }
    public function create(){
        return view('endereco.create');
    }

    public function store(Request $request){



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

        $salvar  = $endereco->save();

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
