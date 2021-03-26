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
            $table->string('email')->unique();
            $table->string('cnpj')->unique();
            $table->unsignedBigInteger('endereco_id')->unsigned() ;
            $table->unsignedBigInteger('usuario_id')->unsigned();
            $table->timestamps();

            //Constrain
            $table->foreign('endereco_id')->references('id')->on('enderecos');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
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