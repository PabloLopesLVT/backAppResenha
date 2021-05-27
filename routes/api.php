<?php

use App\Http\Controllers\api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'guest:api'], function(){
    Route::get('/', function(){

        return "Olá mundo API";
    });
    Route::post('/login', [LoginController::class, 'login']);

});
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/dados', function(){

        return "Olá mundo API (Autenticado)";
    });

    Route::get('/logout', [LoginController::class, 'logout']);


});
Route::post('/tokenizar', [App\Http\Controllers\PagamentoController::class, 'tokenizar']);
Route::post('/efetuar-pagamento', [App\Http\Controllers\PagamentoController::class, 'efetuarPagamento']);

//Criar pedido
Route::post('/criarPedido', [App\Http\Controllers\api\PedidoController::class, 'criarPedido']);
Route::get('/pedidoAberto/{usuario_id}', [App\Http\Controllers\api\PedidoController::class, 'pedidoAberto']);


//Store
Route::post('/storeUsuario', [App\Http\Controllers\api\UsuarioApiController::class, 'store']);
Route::post('/editarUsuario', [App\Http\Controllers\api\UsuarioApiController::class, 'editarUsuario']);
Route::get('/destroyUsuario/{id}', [App\Http\Controllers\api\UsuarioApiController::class, 'destroy']);

//Endereço
Route::post('/createEndereco', [App\Http\Controllers\api\EnderecoController::class, 'createEndereco']);
Route::post('/editarEndereco', [App\Http\Controllers\api\EnderecoController::class, 'editarEndereco']);
Route::get('/destroyEndereco/{idusuario}/{idendereco}', [App\Http\Controllers\api\EnderecoController::class, 'destroy']);

//Buscar Pedido
Route::get('/buscarNomeProdutoEmpresa/{nome}/{latitude}/{longitude}/', [App\Http\Controllers\api\ProdutoEmpresaController::class, 'buscaNome']);
Route::get('/buscarCategoriaProdutoEmpresa/{categoria}/{latitude}/{longitude}/', [App\Http\Controllers\api\ProdutoEmpresaController::class, 'buscaCategoria']);
Route::get('/buscarPreco/{valorinicial}/{valorterminal}/{latitude}/{longitude}/', [App\Http\Controllers\api\ProdutoEmpresaController::class, 'buscaPreco']);

//Categoria
Route::get('/buscarCategorias', [App\Http\Controllers\api\CategoriaController::class, 'index']);


