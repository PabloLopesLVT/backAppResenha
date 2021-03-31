<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_empresas', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->decimal('valor1');
            $table->decimal('valor2');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            //Constrain
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('produto_id')->references('id')->on('produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_empresas');
    }
}
