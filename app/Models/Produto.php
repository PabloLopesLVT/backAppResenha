<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $table = "produtos";
    protected $fillable = [
        'id',
        'nome',
        'marca',
        'status',
        'imagem',
    ];

    public function rules(){
        return [
            'nome' => 'required',
                'marca' => 'required',
                'status' => 'required',
                'imagem' => 'required',
        ];
    }
}
