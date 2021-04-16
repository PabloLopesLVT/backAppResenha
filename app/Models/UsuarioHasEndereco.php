<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioHasEndereco extends Model
{
    use HasFactory;
    protected $table = "usuarios_has_enderecos";

    protected $fillable = [
      'id',
      'usuario_id',
      'endereco_id',
    ];

    public function rules(){
        return [
            'usuario_id' => 'required',
            'endereco_id' => 'required',
        ];
    }
}
