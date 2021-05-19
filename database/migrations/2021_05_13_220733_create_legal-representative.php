<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLegalRepresentative extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('legal_representatives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->unsigned() ;
            $table->string('name'); // Nome do representante legal.
            $table->string('document'); // CPF sem máscara do representante da empresa
            $table->date('birthDate'); // Data de nascimento do representante legal.
            $table->string('motherName'); //Item essencial
            $table->string('type'); //Item essencial
            //Importante sobre os types: Atenção a regra para o campo companyType vs type:
            //INDIVIDUAL: Empresário/ME Individual, somente para EI, MEI, EIRELI;
            //ATTORNEY: Procurador, somente para EI, MEI, EIRELI, LTDA, SA, INSTITUTION_NGO_ASSOCIATION;
            //DESIGNEE: Mandatário", somente para EI, MEI, EIRELI, LTDA, SA, INSTITUTION_NGO_ASSOCIATION;
            //MEMBER: Sócio, somente para LTDA, SA;
            //DIRECTOR: Diretor, somente para INSTITUTION_NGO_ASSOCIATION;
            //PRESIDENT: Presidente, somente para INSTITUTION_NGO_ASSOCIATION
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
        Schema::dropIfExists('legal_representatives');
    }
}
