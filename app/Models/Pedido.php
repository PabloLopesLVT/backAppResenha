<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = "pedidos";
    protected $fillable = [
        'id',
        'produto_empresa_id',
        'empresa_id',
        'usuario_id',
        'valor',
        'status',
        'pago',
        'quantidade',
        'identificacao_pedido'
    ];

    public function rules(){
        return  [
            'produto_empresa_id' => 'required',
            'empresa_id' => 'required',
            'usuario_id' => 'required',
            'valor' => 'required',
            'status' => 'required',
            'quantidade' => 'required'
        ];
    }
}
