<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokenCartao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token_cartoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id') ;
            $table->string('creditCardId');
            $table->string('last4CardNumber');
            $table->string('expirationMonth');
            $table->string('expirationYear');
            $table->timestamps();

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
        Schema::dropIfExists('token_cartoes');
    }
}
