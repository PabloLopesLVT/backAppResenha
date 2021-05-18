<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CompanyMember;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $companyMembers = DB::table('company_members')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('companyMember.listar', compact('companyMembers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();

        $companyMember = new CompanyMember();

        $this->validate($request, $companyMember->rules());

        $companyMember->empresa_id = $empresa_id[0]->empresa_id;
        $companyMember->name = $request->input('name');
        $companyMember->document = $request->input('document');
        $companyMember->birthDate = $request->input('birthDate');
        $salvar  = $companyMember->save();

        if($salvar){
            $status = "success";
            $msg = "Registro salvo com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $companyMembers = DB::table('company_members')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('companyMember.listar', compact('companyMembers'), ['msg' => $msg, 'status' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $companyMember = CompanyMember::find($id);

        return view('companyMember.create', ['companyMember' => $companyMember]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $companyMember = CompanyMember::find($request->input('id'));
        $companyMember->empresa_id = $empresa_id[0]->empresa_id;
        $companyMember->name = $request->input('name');
        $companyMember->document = $request->input('document');
        $companyMember->birthDate = $request->input('birthDate');
        $salvar  = $companyMember->save();

        if($salvar){
            $status = "success";
            $msg = "Atualização salva com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $companyMembers = DB::table('company_members')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('companyMember.listar', compact('companyMembers'), ['msg' => $msg, 'status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companyMember = CompanyMember::find($id);

        try {
            $delete = $companyMember->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //Tenho que ver pra onde vou mandar o cara quando ele deletar
            $msg = "Você não pode excluir o Sócio $companyMember->name porque há registros em dependência desse registro.";
            $status = "danger";
            $empresa_id = DB::table('users')->where('id', Auth::id())->get();
            $companyMembers = DB::table('company_members')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
            return view('companyMember.listar', compact('companyMembers'), ['msg' => $msg, 'status' => $status]);
        }
        if ($delete) {
            $status = "success";
            $msg = "Deleção realizada com sucesso!";
        } else {
            $status = "danger";
            $msg = "Houve um erro na atualização dos dados!";
        }

        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $companyMembers = DB::table('company_members')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('companyMember.listar', compact('companyMembers'), ['msg' => $msg, 'status' => $status]);
    }
}
