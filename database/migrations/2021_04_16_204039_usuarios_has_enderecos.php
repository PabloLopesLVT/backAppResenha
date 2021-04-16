<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UsuariosHasEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios_has_enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id') ;
            $table->unsignedBigInteger('endereco_id') ;
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
        Schema::dropIfExists('usuarios_has_enderecos');
    }
}
