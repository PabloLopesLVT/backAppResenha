<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 Route::get('/dashboard', function () {
        return view('dashboard');
    });
Route::get('/teste', [App\Http\Controllers\GatewayPagamentoController::class, 'teste'])->name('g.teste');

Auth::routes();
/*
Rotas do Administrador Master
*/
Route::group(['middleware' => ['auth:web'] ], function(){

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Create
Route::get('/createEmpresa', [App\Http\Controllers\EmpresaController::class, 'create'])->name('empresa.create');
Route::get('/createUsuario', [App\Http\Controllers\UsuarioController::class, 'create'])->name('usuario.create');
Route::get('/createEndereco', [App\Http\Controllers\EnderecoController::class, 'create'])->name('endereco.create');
Route::get('/createFuncionario', [App\Http\Controllers\FuncionarioController::class, 'create'])->name('funcionario.create');
Route::get('/createProduto', [App\Http\Controllers\ProdutoController::class, 'create'])->name('produto.create');

//Store
Route::post('/storeEmpresa', [App\Http\Controllers\EmpresaController::class, 'store'])->name('empresa.store');
Route::post('/storeEndereco', [App\Http\Controllers\EnderecoController::class, 'store'])->name('endereco.store');
Route::post('/storeUsuario', [App\Http\Controllers\UsuarioController::class, 'store'])->name('usuario.store');
Route::post('/storeFuncionario', [App\Http\Controllers\FuncionarioController::class, 'store'])->name('funcionario.store');
Route::post('/storeProduto', [App\Http\Controllers\ProdutoController::class, 'store'])->name('produto.store');


//listar
Route::get('/listarEndereco', [App\Http\Controllers\EnderecoController::class, 'index'])->name('endereco.index');
Route::get('/listarUsuario', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.index');
Route::get('/listarEmpresa', [App\Http\Controllers\EmpresaController::class, 'index'])->name('empresa.index');
Route::get('/listarFuncionario', [App\Http\Controllers\FuncionarioController::class, 'index'])->name('funcionario.index');
Route::get('/listarProduto', [App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.index');

//Editar
Route::get('/editarEmpresa/{id}', [App\Http\Controllers\EmpresaController::class, 'editar'])->name('empresa.editar');
Route::get('/editarUsuario/{id}', [App\Http\Controllers\UsuarioController::class, 'editar'])->name('usuario.editar');
Route::get('/editarEndereco/{id}', [App\Http\Controllers\EnderecoController::class, 'editar'])->name('endereco.editar');
Route::get('/editarFuncionario/{id}', [App\Http\Controllers\FuncionarioController::class, 'editar'])->name('funcionario.editar');
Route::get('/editarProduto/{id}', [App\Http\Controllers\ProdutoController::class, 'editar'])->name('produto.editar');
Route::post('/produto/status/{id}/{status}', [App\Http\Controllers\ProdutoController::class, 'status'])->name('produto.status');

//Deletar

Route::get('/deletarEmpresa/{id}', [App\Http\Controllers\EmpresaController::class, 'destroy'])->name('empresa.destroy');
Route::get('/deletarUsuario/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('usuario.destroy');
Route::get('/deletarEndereco/{id}', [App\Http\Controllers\EnderecoController::class, 'destroy'])->name('endereco.destroy');
Route::get('/deletarFuncionario/{id}', [App\Http\Controllers\FuncionarioController::class, 'destroy'])->name('funcionario.destroy');
Route::get('/deletarProduto/{id}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produto.destroy');


});
/*
Rotas da Empresa
*/
Route::group(['middleware' => ['auth:web'] ], function(){
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/', function () {
        return view('dashboard');
    });
    //Perfil da Empresa
    Route::get('/editarEmpresaUnica', [App\Http\Controllers\EmpresaController::class, 'editarUnica'])->name('empresa.editarUnica');
    Route::post('/storeEmpresaUnica', [App\Http\Controllers\EmpresaController::class, 'storeUnica'])->name('empresa.storeUnica');

    //Meus Produtos
    Route::get('/produtoEmpresa', [App\Http\Controllers\ProdutoEmpresaController::class, 'index'])->name('produtoEmpresa.index');
    Route::get('/createprodutoEmpresa', [App\Http\Controllers\ProdutoEmpresaController::class, 'create'])->name('produtoEmpresa.create');
    Route::post('/storeprodutoEmpresa', [App\Http\Controllers\ProdutoEmpresaController::class, 'store'])->name('produtoEmpresa.store');
    Route::get('/statusprodutoEmpresa/{id}', [App\Http\Controllers\ProdutoEmpresaController::class, 'checarStatus'])->name('produtoEmpresa.checarStatus');
    Route::get('/editarprodutoEmpresa/{id}', [App\Http\Controllers\ProdutoEmpresaController::class, 'editar'])->name('produtoEmpresa.editar');
    Route::get('/deletarprodutoEmpresa/{id}', [App\Http\Controllers\ProdutoEmpresaController::class, 'destroy'])->name('produtoEmpresa.destroy');


});
