<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('marca');
            $table->integer('status');
            $table->string('imagem');
            $table->unsignedBigInteger('categoria_produto_id')->unsigned() ;
            $table->timestamps();

             //Constrain
             $table->foreign('categoria_produto_id')->references('id')->on('categoria_produtos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
