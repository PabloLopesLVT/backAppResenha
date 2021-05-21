<?php

namespace App\Http\Controllers;

use App\Models\GatewayPagamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $contaDigital = DB::table('conta_digitais')->where('empresa_id', $empresa_id[0]->empresa_id)->get();

        $gateway = new GatewayPagamento();

        //Requisição para obter o saldo da conta
        //Tem que passar a versão da API, o token do recurso, e o JWT
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/documents");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json;charset=UTF-8",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$contaDigital[0]->resourceToken}",
            "Authorization: Bearer {$gateway->getToken()}"
        ]);
        //echo $token->access_token;
        $listaDocumentos = json_decode(curl_exec($ch));
       // var_dump($listaDocumentos->_embedded->documents);
        return view('documento.listar', ['documentos' => $listaDocumentos->_embedded->documents]);
    }
    public function upload(Request $request){

        $empresa_id = DB::table('users')->where('id', Auth::id())->get();
        $contaDigital = DB::table('conta_digitais')->where('empresa_id', $empresa_id[0]->empresa_id)->get();
        $gateway = new GatewayPagamento();

        $folderPath = storage_path('/app/public/documentos/');

        $image_parts = explode(";base64,", $request->imagem);

        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $imageName = uniqid() . '.jpeg';

        $imageFullPath = $folderPath.$imageName;
        file_put_contents($imageFullPath, $image_base64);
        $file = curl_file_create($imageFullPath,'image/jpg','img.jpg');
        $data = array(
            "files" =>  $file
        );

        //Requisição para obter o JWT
        //doc_EFF6E3FA7FB99EF1 = ao id do documento obtido pelo listar
        $ch = curl_init("https://sandbox.boletobancario.com/api-integration/documents/{$request->input('iddocumento')}/files");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: multipart/form-data",
            "X-Api-Version:  2",
            "X-Resource-Token:  {$contaDigital[0]->resourceToken}",
            "Authorization: Bearer {$gateway->getToken()}",

        ]);
        $doc = json_decode(curl_exec($ch));

        if($doc->approvalStatus == "VERIFYING"){
            session()->flash('status', 'success');
            session()->flash('msg', 'Arquivo enviado com sucesso.');
            return redirect()->back();
        }else{
            session()->flash('status', 'danger');
            session()->flash('msg', 'Erro ao enviar arquivo.');
            return redirect()->back();
        }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
