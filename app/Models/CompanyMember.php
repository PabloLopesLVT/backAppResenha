<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyMember extends Model
{
    use HasFactory;

    protected $table = "company_members";

    protected $fillable = [
        'empresa_id',
        'name',
        'document',
        'birthDate'
    ];

    public function rules(){
        return [
            'name' => 'required',
            'document'  => 'required|cpf',
            'birthDate'  => 'required'
        ];
    }
}
