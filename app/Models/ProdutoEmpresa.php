<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoEmpresa extends Model
{
    use HasFactory;
    protected $table = "produtos_empresas";

    protected $fillable = [
        'id',
        'quantidade',
        'valor1',
        'valor2',
        'produto_id',
        'empresa_id'
    ];

    public function rules(){
        return [
            'quantidade' => 'required',
                'valor1' => 'required',
                'valor2' => 'required',
                'produto_id' => 'required',
                'empresa_id' => 'required',
        ];
    }
}
