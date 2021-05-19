<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $bankAccounts = DB::table('bank_accounts')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('bankAccount.listar', compact('bankAccounts'));
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

        $bankAccount = new BankAccount();
        $status = "";
        $msg = "";
            $this->validate($request, $bankAccount->rules());

            $bankAccount->empresa_id = $empresa_id[0]->empresa_id;
            $bankAccount->bankNumber = $request->input('bankNumber');
            $bankAccount->agencyNumber = $request->input('agencyNumber');
            $bankAccount->accountNumber = $request->input('accountNumber');
            $bankAccount->accountComplementNumber = $request->input('accountComplementNumber');
            $bankAccount->accountType = $request->input('accountType');
            $bankAccount->accountHolderName = $request->input('accountHolderName');
            $bankAccount->accountHolderCPF = $request->input('accountHolderCPF');
            $salvar  = $bankAccount->save();

            if($salvar){
                $status = "success";
                $msg = "Registro salvo com sucesso!";
            }else{
                $status = "danger";
                $msg = "Houve erro ao salvar o registro!";
            }



        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $bankAccounts = DB::table('bank_accounts')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('bankAccount.listar', compact('bankAccounts'), ['msg' => $msg, 'status' => $status]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAccount = BankAccount::find($id);

        return view('bankAccount.create', ['bankAccount' => $bankAccount]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $bankAccount = BankAccount::find($request->input('id'));
        $bankAccount->empresa_id = $empresa_id[0]->empresa_id;
        $bankAccount->bankNumber = $request->input('bankNumber');
        $bankAccount->agencyNumber = $request->input('agencyNumber');
        $bankAccount->accountNumber = $request->input('accountNumber');
        $bankAccount->accountComplementNumber = $request->input('accountComplementNumber');
        $bankAccount->accountType = $request->input('accountType');
        $bankAccount->accountHolderName = $request->input('accountHolderName');
        $bankAccount->accountHolderCPF = $request->input('accountHolderCPF');
        $update  = $bankAccount->update();

        if($update){
            $status = "success";
            $msg = "Atualização salva com sucesso!";
        }else{
            $status = "danger";
            $msg = "Houve erro ao salvar o registro!";
        }
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $bankAccounts = DB::table('bank_accounts')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        return view('bankAccount.listar', compact('bankAccounts'), ['msg' => $msg, 'status' => $status]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
