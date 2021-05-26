<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cobranca extends Model
{
    use HasFactory;

    protected $table = 'cobrancas';

    protected $fillable = [
        'pedido',
        'idCobranca',
        'code',
        'reference',
        'dueDate',
        'checkoutUrl',
        'amount',
        'status',
        'link'
    ];


}
