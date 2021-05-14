<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->unsigned() ;
            $table->string('bankNumber', 3); //Código de compensação dos bancos do Brasil. Espera 3 digitos.
            $table->string('agencyNumber'); //Número da agência. Deve respeitar o padrão de cada banco.
            $table->string('accountNumber'); //Número da conta. Deve respeitar o padrão de cada banco.
            $table->string('accountComplementNumber')->nullable(); //Complemento da conta a ser criada. Exclusivo e obrigatório apenas para contas Caixa.
            $table->enum('accountType', ['CHECKING', 'SAVINGS']); //Enum: "CHECKING" "SAVINGS" Tipo da conta. Envie CHECKING para Conta Corrente e SAVINGS para Poupança.
            $table->string('accountHolderName'); //Nome do titular da conta bancária.
            $table->string('accountHolderCPF'); //Sem máscara - CPF do titular da conta bancária. Envie sem ponto ou traço.
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank-accounts');
    }
}
