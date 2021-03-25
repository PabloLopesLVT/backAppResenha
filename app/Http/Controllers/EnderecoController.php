<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    public function index()
    {

        $endereco = new Endereco();
        $enderecos = $endereco::all();
        return view('endereco.listar', compact('enderecos'));
    }
    public function create()
    {
        return view('endereco.create');
    }

    public function store(Request $request)
    {

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

        if ($request->id == '') {

            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');

            $salvar  = $endereco->save();

            if ($salvar) {
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            } else {
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        } else {
            $endereco  = Endereco::find($request->input('id'));
            $endereco->logradouro = $request->input('logradouro');
            $endereco->numero = $request->input('numero');
            $endereco->bairro = $request->input('bairro');
            $endereco->cep = $request->input('cep');
            $endereco->municipio = $request->input('municipio');
            $endereco->estado = $request->input('estado');
            $endereco->complemento = $request->input('complemento');

            $update  = $endereco->update();

            if ($update) {
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            } else {
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }
        return view('endereco.create', ['msg' => $msg, 'status' => $status]);
    }

    public function editar($id)
    {
        $endereco = Endereco::find($id);

        return view('endereco.create', ['endereco' => $endereco]);
    }

    public function destroy($id)
    {
        $endereco = Endereco::find($id);

        try {
            $delete = $endereco->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o endereco $endereco->logradouro porque há registros em dependência desse registro.";
            $status = "danger";
            $enderecos = Endereco::get();
            return view('endereco.listar', ['msg' => $msg, 'status' => $status], compact('enderecos'));
        }
        if ($delete) {
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        } else {
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }


        return view('endereco.create', ['msg' => $msg, 'status' => $status]);
    }
}
