<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $table = "bank_accounts";

    protected $fillable = [
        "empresa_id",
        "bankNumber",
        "agencyNumber",
        "accountNumber",
        "accountComplementNumber",
        "accountType",
        "accountHolderName",
        "accountHolderCPF"
        ];

    public function rules(){
        return [
            "bankNumber" => 'required',
            "agencyNumber" => 'required',
            "accountNumber" => 'required',
            "accountType" => 'required',
            "accountHolderName" => 'required',
            "accountHolderCPF" => 'required'
        ];
    }
}
