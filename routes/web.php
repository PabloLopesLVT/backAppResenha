<?php

use App\Events\FormSubmitted;
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


 Route::get('/site', [App\Http\Controllers\Site\SiteController::class, 'index']);

 Route::get('/dashboard', function () {
        return view('dashboard');
    });
    Route::get('/test', function () {
        return view('test.test');
    });
    Route::get('/sender', function () {
        return view('test.sender');
    });
    Route::post('/sender', function () {
        //This is the post
        $text = request()->input('content');
        $for_user_id = request()->input('for_user_id');
        event(new FormSubmitted($text,$for_user_id));
    });
Route::get('/teste', [App\Http\Controllers\GatewayPagamentoController::class, 'teste'])->name('g.teste');

Auth::routes();
/*
Rotas do Administrador Master
*/
Route::group(['middleware' => ['auth:web', 'is_admin'] ], function(){

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Conta Digital

    Route::get('/contaDigitalCreate/{id}', [App\Http\Controllers\ContaDigitalController::class, 'create'])->name('conta-digital.create');


//Company
Route::apiResource('empresa', 'App\Http\Controllers\EmpresaController');
//Link Criar Nova Empresa
Route::get('/createEmpresa', [App\Http\Controllers\EmpresaController::class, 'create'])->name('empresa.create');
//Deletar via AJAX
Route::get('/deletarEmpresa/{id}', [App\Http\Controllers\EmpresaController::class, 'destroy'])->name('empresa.destroy');


//Create
Route::get('/createUsuario', [App\Http\Controllers\UsuarioController::class, 'create'])->name('usuario.create');
Route::get('/createEndereco', [App\Http\Controllers\EnderecoController::class, 'create'])->name('endereco.create');
Route::get('/createFuncionario', [App\Http\Controllers\FuncionarioController::class, 'create'])->name('funcionario.create');
Route::get('/createProduto', [App\Http\Controllers\ProdutoController::class, 'create'])->name('produto.create');

//Store
Route::post('/storeEndereco', [App\Http\Controllers\EnderecoController::class, 'store'])->name('endereco.store');
Route::post('/storeUsuario', [App\Http\Controllers\UsuarioController::class, 'store'])->name('usuario.store');
Route::post('/storeFuncionario', [App\Http\Controllers\FuncionarioController::class, 'store'])->name('funcionario.store');
Route::post('/storeProduto', [App\Http\Controllers\ProdutoController::class, 'store'])->name('produto.store');


//listar
Route::get('/listarEndereco', [App\Http\Controllers\EnderecoController::class, 'index'])->name('endereco.index');
Route::get('/listarUsuario', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.index');
Route::get('/listarFuncionario', [App\Http\Controllers\FuncionarioController::class, 'index'])->name('funcionario.index');
Route::get('/listarProduto', [App\Http\Controllers\ProdutoController::class, 'index'])->name('produto.index');

//Editar
Route::get('/editarUsuario/{id}', [App\Http\Controllers\UsuarioController::class, 'editar'])->name('usuario.editar');
Route::get('/editarEndereco/{id}', [App\Http\Controllers\EnderecoController::class, 'editar'])->name('endereco.editar');
Route::get('/editarFuncionario/{id}', [App\Http\Controllers\FuncionarioController::class, 'editar'])->name('funcionario.editar');
Route::get('/editarProduto/{id}', [App\Http\Controllers\ProdutoController::class, 'editar'])->name('produto.editar');
Route::post('/produto/status/{id}/{status}', [App\Http\Controllers\ProdutoController::class, 'status'])->name('produto.status');

//Deletar

Route::get('/deletarUsuario/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('usuario.destroy');
Route::get('/deletarEndereco/{id}', [App\Http\Controllers\EnderecoController::class, 'destroy'])->name('endereco.destroy');
Route::get('/deletarFuncionario/{id}', [App\Http\Controllers\FuncionarioController::class, 'destroy'])->name('funcionario.destroy');
Route::get('/deletarProduto/{id}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->name('produto.destroy');


//Categoria
Route::get('/createCategoria', [App\Http\Controllers\CategoriaProdutoController::class, 'create'])->name('categoria.create');
Route::post('/storeCategoria', [App\Http\Controllers\CategoriaProdutoController::class, 'store'])->name('categoria.store');
Route::get('/listarCategoria', [App\Http\Controllers\CategoriaProdutoController::class, 'index'])->name('categoria.index');
Route::get('/editarCategoria/{id}', [App\Http\Controllers\CategoriaProdutoController::class, 'editar'])->name('categoria.editar');
Route::get('/deletarCategoria{id}', [App\Http\Controllers\CategoriaProdutoController::class, 'destroy'])->name('categoria.destroy');

Route::apiResource('business-area', 'App\Http\Controllers\BusinessAreaController');
Route::apiResource('type-company', 'App\Http\Controllers\TypeCompanyController');

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
    Route::put('/editarEmpresaUnica/{id}', [App\Http\Controllers\EmpresaController::class, 'updateUnica'])->name('empresa.updateUnica');

    //Company Member

    Route::apiResource('company-member', 'App\Http\Controllers\CompanyMemberController');
    //Deletar via AJAX
    Route::get('/deletarCompanyMember/{id}', [App\Http\Controllers\CompanyMemberController::class, 'destroy'])->name('company-member.destroy');

    Route::get('company-member-create', function (){
        return view('companyMember.create');
    })->name('company-member.create');

    //Bank Account
    Route::apiResource('bank-account', 'App\Http\Controllers\BankAccountController');
    Route::get('bank-accountCreate', function (){
        return view('bankAccount.create');
    })->name('bank-account.create');


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
