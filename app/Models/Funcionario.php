<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    protected $table = "funcionarios";

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'email',
        'cpf',
        'funcao',
        'endereco_id',
    ];

    public function rules(){
        return [
            'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email|unique:usuarios',
                'cpf' => 'required|cpf|unique:usuarios',
                'funcao' => 'required',
                'endereco_id' => 'required',
        ];
    }
}
