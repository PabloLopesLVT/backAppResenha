<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenCartao extends Model
{
    use HasFactory;

    protected $table = 'token_cartoes';
    protected $fillable = [
        "creditCardId",
        "last4CardNumber",
        "expirationMonth",
        "expirationYear"
    ];

    public function rules(){
        return [
            "creditCardId" => 'required',
            "last4CardNumber" => 'required',
            "expirationMonth" => 'required',
            "expirationYear" => 'required'
        ];
    }
}
