<?php

namespace App\Http\Controllers;

use App\Models\BusinessArea;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\LegalRepresentative;
use App\Models\TypeCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index(){

        $empresas = DB::table('empresas AS e')
        ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
        ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
        ->get();

        return view('empresa.listar', compact('empresas'));
    }
    public function create(){
        $endereco = new Endereco();
        $enderecos = $endereco::all();
        $businessArea = new BusinessArea();
        $typeCompany = new TypeCompany();
        $businessAreas = $businessArea->getBusinessArea();
        $businessAreas = $businessAreas->getOriginalContent()["dados"]->_embedded->businessAreas;
        $typeCompany = $typeCompany->getTypeCompany();
        $typeCompanys = $typeCompany->getOriginalContent()["dados"]->companyTypes;

        return view('empresa.create', compact('enderecos', 'businessAreas','typeCompanys'));
    }
    public function updateUnica(Request $request, $id){
        $endereco  = Endereco::find($request->input('idendereco'));
        $endereco->logradouro = $request->input('logradouro');
        $endereco->numero = $request->input('numero');
        $endereco->bairro = $request->input('bairro');
        $endereco->cep = $request->input('cep');
        $endereco->municipio = $request->input('municipio');
        $endereco->estado = $request->input('estado');
        $endereco->complemento = $request->input('complemento');
        $endereco->observacoes = $request->input('observacoes');
        $endereco->latitude = $request->input('latitude');
        $endereco->longitude = $request->input('longitude');
        $salvar  = $endereco->save();

        $empresa  = Empresa::find($request->input('id'));
        $empresa->nomeEmpresa = $request->input('nomeEmpresa');
        $empresa->email = $request->input('email');
        $empresa->celular = $request->input('telefone');
        $empresa->razaoSocial = $request->input('razaoSocial');
        $empresa->responsavel = $request->input('responsavel');
        $empresa->cnpj = $request->input('cnpj');
        $empresa->businessArea = $request->input('businessArea');
        $empresa->linesOfBusiness = $request->input('linesOfBusiness');
        $empresa->companyType =$request->input('typeCompany');;
        $empresa->monthlyIncomeOrRevenue =  str_replace(['.',','],'',  $request->input('monthlyIncomeOrRevenue'));
        $empresa->cnae = $request->input('cnae');
        $empresa->establishmentDate = $request->input('establishmentDate');
        $empresa->endereco_id = $request->input('idendereco');

        $update = $empresa->update();
        if($update){
            $status = "success";
            $msg = "Atualização realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }
        $empresas = DB::table('empresas AS e')
            ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
            ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
            ->get();
            return view('dashboard', compact('empresas'), ['msg' => $msg, 'status' => $status]);
    }

    public function update(Request $request, $id){
        $endereco  = Endereco::find($request->input('idendereco'));
        $endereco->logradouro = $request->input('logradouro');
        $endereco->numero = $request->input('numero');
        $endereco->bairro = $request->input('bairro');
        $endereco->cep = $request->input('cep');
        $endereco->municipio = $request->input('municipio');
        $endereco->estado = $request->input('estado');
        $endereco->complemento = $request->input('complemento');
        $endereco->observacoes = $request->input('observacoes');
        $endereco->latitude = $request->input('latitude');
        $endereco->longitude = $request->input('longitude');
        $salvar  = $endereco->save();

        $empresa  = Empresa::find($request->input('id'));
        $empresa->nomeEmpresa = $request->input('nomeEmpresa');
        $empresa->email = $request->input('email');
        $empresa->celular = $request->input('telefone');
        $empresa->razaoSocial = $request->input('razaoSocial');
        $empresa->responsavel = $request->input('responsavel');
        $empresa->cnpj = $request->input('cnpj');
        $empresa->businessArea = $request->input('businessArea');
        $empresa->linesOfBusiness = $request->input('linesOfBusiness');
        $empresa->companyType =$request->input('typeCompany');;
        $empresa->monthlyIncomeOrRevenue =  str_replace(['.',','],'',  $request->input('monthlyIncomeOrRevenue'));
        $empresa->cnae = $request->input('cnae');
        $empresa->establishmentDate = $request->input('establishmentDate');
        $empresa->endereco_id = $request->input('idendereco');

        $update = $empresa->update();
        if($update){
            $status = "success";
            $msg = "Atualização realizada com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }
        $empresas = DB::table('empresas AS e')
            ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
            ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
            ->get();
        return view('empresa.listar', compact('empresas'), ['msg' => $msg, 'status' => $status]);
    }

    public function editarUnica(){

        $user = DB::table('users')->where('id', Auth::id())->get();
        $empresa = Empresa::find($user[0]->empresa_id);
        $endereco = Endereco::find($empresa->endereco_id);
        $legalRepresentative = DB::table('legal_representatives')->where('empresa_id', $user[0]->empresa_id)->get();

        $businessArea = new BusinessArea();
        $typeCompany = new TypeCompany();
        $businessAreas = $businessArea->getBusinessArea();
        $businessAreas = $businessAreas->getOriginalContent()["dados"]->_embedded->businessAreas;
        $typeCompany = $typeCompany->getTypeCompany();
        $typeCompanys = $typeCompany->getOriginalContent()["dados"]->companyTypes;
        return view('perfilEmpresa.editar',compact('businessAreas', 'typeCompanys'), ['empresa' => $empresa, 'endereco' => $endereco, 'legalRepresentative' => $legalRepresentative[0]]);
    }

    public function store(Request $request){

        $empresa = new Empresa();
        $status = "";
        $msg = "";
        $endereco = new Endereco();
        $legalR = new LegalRepresentative();



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
            $endereco->latitude = $request->input('latitude');
            $endereco->longitude = $request->input('longitude');
            $salvar  = $endereco->save();

            if($salvar){

            $endereco  = DB::table('enderecos')->orderBy('id', 'desc')->first();
            $empresa->nomeEmpresa = $request->input('nomeEmpresa');
            $empresa->email = $request->input('email');
            $empresa->celular = $request->input('telefone');
            $empresa->razaoSocial = $request->input('razaoSocial');
            $empresa->responsavel = $request->input('responsavel');
            $empresa->cnpj = $request->input('cnpj');
            $empresa->businessArea = $request->input('businessArea');
            $empresa->linesOfBusiness = $request->input('linesOfBusiness');
            $empresa->companyType = $request->input('typeCompany');
                $empresa->monthlyIncomeOrRevenue =  str_replace(['.',','],'',  $request->input('monthlyIncomeOrRevenue'));
            $empresa->cnae = $request->input('cnae');
            $empresa->establishmentDate = $request->input('establishmentDate');
            $empresa->endereco_id = $endereco->id;

            $salvarEmpresa = $empresa->save();

            if($salvarEmpresa){
                $lastIdEmpresa  = DB::table('empresas')->orderBy('id', 'desc')->first();


                $this->validate($request, $legalR->rules());
                $legalR->empresa_id = $lastIdEmpresa->id;
                $legalR->name = $request->input('name');
                $legalR->document = $request->input('document');
                $legalR->birthDate = $request->input('birthDate');
                $legalR->motherName = $request->input('motherName');
                $legalR->type = $request->input('type');
                $salvarLegalR = $legalR->save();


                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }
        }

     $empresas = DB::table('empresas AS e')
     ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
     ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
     ->get();
        return view('empresa.listar', compact('empresas'), ['msg' => $msg, 'status' => $status]);
    }
public  function show($id){
    $empresa = Empresa::find($id);
    $endereco = Endereco::find($empresa->endereco_id);
    $legalRepresentative = DB::table('legal_representatives')->where('empresa_id', $id)->get();
    $businessArea = new BusinessArea();
    $typeCompany = new TypeCompany();
    $businessAreas = $businessArea->getBusinessArea();
    $businessAreas = $businessAreas->getOriginalContent()["dados"]->_embedded->businessAreas;
    $typeCompany = $typeCompany->getTypeCompany();
    $typeCompanys = $typeCompany->getOriginalContent()["dados"]->companyTypes;

    return view('empresa.create', compact('businessAreas', 'typeCompanys'), ['empresa' => $empresa, 'endereco' => $endereco, 'legalRepresentative' => $legalRepresentative[0]]);
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

        $empresas = DB::table('empresas AS e')
        ->select('e.id AS idempresa', 'e.nomeEmpresa', 'e.email', 'e.cnpj','e.responsavel','e.razaoSocial','e.celular', 'enderecos.logradouro', 'enderecos.municipio', 'enderecos.estado')
        ->join('enderecos', 'e.endereco_id', '=', 'enderecos.id')
        ->get();
        return view('empresa.listar', compact('empresas'), ['msg' => $msg, 'status' => $status]);
    }
}
