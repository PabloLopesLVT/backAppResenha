<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaDigital extends Model
{
    use HasFactory;

    protected $table = "conta_digitais";

    protected $fillable = [
        'idConta',
        'type',
        'status',
        'personType',
        'document',
        'createdOn',
        'resourceToken',
        'accountNumber',
        'link'
    ];
}
