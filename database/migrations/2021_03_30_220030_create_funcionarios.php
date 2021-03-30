<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('funcao');
            $table->unsignedBigInteger('endereco_id')->unsigned() ;
            $table->unsignedBigInteger('empresa_id')->unsigned() ;

            $table->timestamps();
            //Constrain
            $table->foreign('endereco_id')->references('id')->on('enderecos');
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
        Schema::dropIfExists('funcionarios');
    }
}
