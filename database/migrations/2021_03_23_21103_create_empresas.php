<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nomeEmpresa');
            $table->string('razaoSocial');
            $table->string('celular');
            $table->string('responsavel');
            $table->string('email')->unique();
            $table->string('cnpj')->unique();

            $table->string('businessArea'); // Define a área de negócio da empresa. Para consultar os valores permitidos, consulte linhas de negócio.
            $table->string('linesOfBusiness'); // Define a linha de negócio da empresa. Campo de livre preenchimento.
            $table->string('companyType'); // Define a natureza de negócio. Obrigatório para contas PJ. Para consultar os valores permitidos, consulte tipos de empresa.
            $table->float('monthlyIncomeOrRevenue'); // Renda mensal ou receita. Obrigatório para PF e PJ.
            $table->string('cnae'); // Campo destinado ao CNAE(Classificação Nacional de Atividades Econômicas) da empresa. Obrigatório para PJ.
            $table->string('establishmentDate'); // Data de abertura da empresa. Obrigatório para PJ.
            $table->boolean('pep'); // Define se o cadastro pertence a uma pessoa politicamente exposta.


            $table->unsignedBigInteger('endereco_id')->unsigned() ;


            $table->timestamps();

            //Constrain
            $table->foreign('endereco_id')->references('id')->on('enderecos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
