<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CompanyMember;
use App\Models\ContaDigital;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\GatewayPagamento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContaDigitalController extends Controller
{
    function __construct()
    {
        $this->setToken(env('TOKEN_JUNO'));
    }

    private $token;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * Limpa os caracteres especiais das máscaras
     * @param $valor
     * @return array|string|string[]|null
     */
    public function limparCaracteres($valor)
    {
        $valor = preg_replace('/[^0-9]/', '', $valor);
        return $valor;
    }

    public function create($id)
    {
        $contaDigital = DB::table('conta_digitais')->where('empresa_id', $id)->get();
        $legalRepresentative = DB::table('legal_representatives')->where('empresa_id', $id)->get();
        $bankAccount = DB::table('bank_accounts')->where('empresa_id', $id)->get();
        $empresa = Empresa::find($id);
        $endereco = Endereco::find($empresa->endereco_id);
        if ($contaDigital->isEmpty()) {
            if($legalRepresentative->isEmpty() || $bankAccount->isEmpty()){
                return view('contaDigital.response', ['msg' => 'Check novamente os Legal Representande e os dados Bancárcios']);
            }


        $legalRepresentative = $legalRepresentative[0];
        $bankAccount = $bankAccount[0];
        $gateway = new GatewayPagamento();

            $dadosTableEmpresa = array(
                "type" => "PAYMENT", // Conta de pagamento
                "name" => $empresa->razaoSocial,
                "document" => $this->limparCaracteres($empresa->cnpj),
                "email" => $empresa->email,
                "phone" => $this->limparCaracteres($empresa->celular),
                "businessArea" => $empresa->businessArea, // Tem que acessar a API para ver os códigos
                "linesOfBusiness" => $empresa->linesOfBusiness,
                "companyType" => $empresa->companyType,
                "monthlyIncomeOrRevenue" => $empresa->monthlyIncomeOrRevenue,
                "cnae" => $this->limparCaracteres($empresa->cnae),
                "establishmentDate" => $empresa->establishmentDate,
                "pep" => false,
                "emailOptOut" => false, //Para impedir o Juno enviar e-mail para os usuários
            );
            $lr = array(
                "legalRepresentative" => array(
                    "name" => $legalRepresentative->name,
                    "document" => $this->limparCaracteres($legalRepresentative->document),
                    "motherName" => $legalRepresentative->motherName,
                    "birthDate" => $legalRepresentative->birthDate,
                    "type" => $legalRepresentative->type
                )
            );

            $tableEndereco = array(
                "address" => array(
                    "street" => $endereco->logradouro,
                    "number" => $endereco->numero,
                    "complement" => $endereco->complement,
                    "neighborhood" => $endereco->bairro,
                    "city" => $endereco->municipio,
                    "state" => $endereco->estado,
                    "postCode" => $this->limparCaracteres($endereco->cep)
                )
            );
            $bankAccount = array(
                "bankAccount" => array(
                    "bankNumber" => $bankAccount->bankNumber,
                    "agencyNumber" => $bankAccount->agencyNumber,
                    "accountNumber" => $bankAccount->accountNumber,
                    "accountType" => $bankAccount->accountType,
                    "accountHolder" => array(
                        "name" => $bankAccount->accountHolderName,
                        "document" => $this->limparCaracteres($bankAccount->accountHolderCPF)
                    ),
                ),
            );
            //Se o Tipo de Empresa for igual a LTDA ou SA é obrigatório o companyMember
            if($empresa->companyType == "LTDA" || $empresa->companyType == "SA"){
                $companyMember = DB::table('company_members')->where('empresa_id', $id)->get();
                $companyMember = $companyMember[0];
                $companyMember = array(
                    "companyMembers" => array(
                        "name" => $companyMember->name,
                        "document" => $this->limparCaracteres($companyMember->document),
                        "birthDate" => $companyMember->birthDate
                    )
                );
                $data = array_merge($dadosTableEmpresa, $lr, $tableEndereco, $bankAccount, $companyMember);
            }else{
                $data = array_merge($dadosTableEmpresa, $lr, $tableEndereco, $bankAccount);
            }


            $data = json_encode($data);

            //Requisição para obter o JWT
            $ch = curl_init("https://sandbox.boletobancario.com/api-integration/digital-accounts");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json;charset=UTF-8",
                "X-Api-Version:  2",
                "X-Resource-Token:  {$this->getToken()}",
                "Authorization: Bearer {$gateway->getToken()}",

            ]);

            $criarconta = json_decode(curl_exec($ch));

            if ($criarconta->status == 'AWAITING_DOCUMENTS') {
                $contaDigital = new ContaDigital();
                $contaDigital->empresa_id = $id;
                $contaDigital->idConta = $criarconta->id;
                $contaDigital->type = $criarconta->type;
                $contaDigital->status = $criarconta->status;
                $contaDigital->personType = $criarconta->personType;
                $contaDigital->document = $criarconta->document;
                $contaDigital->createdOn = $criarconta->createdOn;
                $contaDigital->resourceToken = $criarconta->resourceToken;
                $contaDigital->accountNumber = $criarconta->accountNumber;
                $contaDigital->link = $criarconta->_links->self->href;
                $contaDigital->save();
                return view('contaDigital.response', ['status' => $criarconta->status, 'msg' => 'Conta digital criada com sucesso!']);

            }else if($criarconta->status == 400){
                return view('contaDigital.response', ['status' => $criarconta->status, 'msg' => $criarconta]);
            }
            else {
                return view('contaDigital.response', ['status' => $criarconta->status, 'msg' => $criarconta]);
            }
        } else {

            return view('contaDigital.response', ['msg' => 'Conta Já existe!']);

        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
