<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = "usuarios";

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'email',
        'cpf',
        'tipo'
    ];

    public function rules(){
        return [
            'nome' => 'required',
                'sobrenome' => 'required',
                'email' => 'required|email|unique:usuarios',
                'cpf' => 'required|cpf|unique:usuarios',
                'tipo' => 'required'
        ];
    }
}
