<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProduto extends Model
{
    use HasFactory;
    protected $table = "categoria_produtos";
    protected $fillable = [
        'id',
        'nome',
        'icone'
    ];

    public function rules(){
        return [
            'nome' => 'required',
            'icone' => 'required',
        ];
    }

}
