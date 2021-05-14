<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalRepresentative extends Model
{

    use HasFactory;
    protected $table = "legal_representatives";

    protected $fillable = [
        "empresa_id",
        "name",
        "document",
        "birthDate",
        "motherName",
        "type"
    ];

    public function rules(){
        return [
            "name" => 'required',
            "document" => 'required',
            "birthDate" => 'required',
            "motherName" => 'required',
            "type" => 'required'
        ];
    }
}
