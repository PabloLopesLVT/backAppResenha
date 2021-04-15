<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ProdutoEmpresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoEmpresaController extends Controller
{
    public function buscaNome($nome, $latitude, $longitude)
    {
        try {


            $msg = "";

            $produtoEmpresa = DB::table('produtos_empresas')
                ->when($nome, function ($query, $nome) {
                    return $query->where('produtos.nome', 'like', '%' . $nome . '%');
                })
                ->join('produtos', 'produtos_empresas.produto_id', '=', 'produtos.id')
                ->join('empresas', 'produtos_empresas.empresa_id', '=', 'empresas.id')
                ->join('enderecos', 'empresas.endereco_id', '=', 'enderecos.id')
                ->get();

            foreach ($produtoEmpresa as $key => $value) {

                $km = $this->calcDistancia($latitude, $longitude, $produtoEmpresa[$key]->latitude, $produtoEmpresa[$key]->longitude);
                if ($km > 10) {
                    $produtoEmpresa->forget($key);
                } else {
                    $produtoEmpresa->push('km', $km);
                }
                $produtoEmpresa = $produtoEmpresa->sortBy('km');
            }

            return response()->json([$produtoEmpresa], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Erro'], 404);
        }
    }
    public function buscaCategoria($categoria, $latitude, $longitude)
    {
        try {


            $msg = "";

            $produtoEmpresa = DB::table('produtos_empresas')
                ->when($categoria, function ($query, $categoria) {
                    return $query->where('categoria_produtos.id', '=', $categoria);
                })
                ->join('produtos', 'produtos_empresas.produto_id', '=', 'produtos.id')
                ->join('categoria_produtos', 'produtos.categoria_produto_id', '=', 'categoria_produtos.id')
                ->join('empresas', 'produtos_empresas.empresa_id', '=', 'empresas.id')
                ->join('enderecos', 'empresas.endereco_id', '=', 'enderecos.id')
                ->get();
            foreach ($produtoEmpresa as $key => $value) {

                $km = $this->calcDistancia($latitude, $longitude, $produtoEmpresa[$key]->latitude, $produtoEmpresa[$key]->longitude);
                if ($km > 10) {
                    $produtoEmpresa->forget($key);
                } else {
                    $produtoEmpresa->push('km', $km);
                }
                $produtoEmpresa = $produtoEmpresa->sortBy('km');
            }
            return response()->json([$produtoEmpresa], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Erro'], 404);
        }
    }

    public function buscaPreco($valorinicial, $valorterminal, $latitude, $longitude)
    {
        try {


            $msg = "";

            $valor_filtro = array(
                "valorinicial" => $valorinicial,
                "valorterminal" => $valorterminal,
            );

            $produtoEmpresa = DB::table('produtos_empresas')
                ->when($valor_filtro, function ($query, $valor_filtro) {
                    return $query->whereBetween('produtos_empresas.valor2', [$valor_filtro['valorinicial'], $valor_filtro['valorterminal']]);
                })
                ->join('empresas', 'produtos_empresas.empresa_id', '=', 'empresas.id')
                ->join('enderecos', 'empresas.endereco_id', '=', 'enderecos.id')
                ->get();
            foreach ($produtoEmpresa as $key => $value) {

                $km = $this->calcDistancia($latitude, $longitude, $produtoEmpresa[$key]->latitude, $produtoEmpresa[$key]->longitude);
                if ($km > 10) {
                    $produtoEmpresa->forget($key);
                } else {
                    $produtoEmpresa->push('km', $km);
                }
                $produtoEmpresa = $produtoEmpresa->sortBy('km');
            }
            return response()->json([$produtoEmpresa], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Erro'], 404);
        }
    }


    public function calcDistancia($lat1, $long1, $lat2, $long2)
    {
        $d2r = 0.017453292519943295769236;

        $dlong = ($long2 - $long1) * $d2r;
        $dlat = ($lat2 - $lat1) * $d2r;

        $temp_sin = sin($dlat / 2.0);
        $temp_cos = cos($lat1 * $d2r);
        $temp_sin2 = sin($dlong / 2.0);

        $a = ($temp_sin * $temp_sin) + ($temp_cos * $temp_cos) * ($temp_sin2 * $temp_sin2);
        $c = 2.0 * atan2(sqrt($a), sqrt(1.0 - $a));

        return 6368.1 * $c;
    }
}
