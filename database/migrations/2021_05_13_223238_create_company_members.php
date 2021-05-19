<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->unsigned() ;
            $table->string('name'); //Nome do membro.
            $table->string('document'); //CPF ou CNPJ (provavelmente sem máscara, pois o outros pedem assim)
            $table->string('birthDate');//string <yyyy-MM-dd> 10 characters Data de nascimento do membro.
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
        Schema::dropIfExists('company_members');
    }
}
