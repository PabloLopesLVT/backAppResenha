<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaDigitais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_digitais', function (Blueprint $table) {
            $table->id();
            $table->string('idConta');
            $table->unsignedBigInteger('empresa_id')->unsigned() ;
            $table->string('type');
            $table->string('status');
            $table->string('personType');
            $table->string('document');
            $table->string('createdOn');
            $table->string('resourceToken');
            $table->integer('accountNumber');
            $table->string('link');
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
        Schema::dropIfExists('conta_digitais');
    }
}
