<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProduto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            $categorias = CategoriaProduto::all();
            return response()->json([$categorias], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message'=> 'Erro'], 404);
        }
    }
}
