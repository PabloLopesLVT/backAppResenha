<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = "empresas";

    protected $fillable = [
        'id',
        'nomeEmpresa',
        'razaoSocial',
        'responsavel',
        'celular',
        'email',
        'cnpj',
        'endereco_id',
        'usuario_id',
        'businessArea',
        'linesOfBusiness',
        'companyType',
        'monthlyIncomeOrRevenue',
        'cnae',
        'establishmentDate'
    ];
}
