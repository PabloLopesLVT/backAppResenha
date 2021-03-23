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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Create
Route::get('/createEmpresa', [App\Http\Controllers\EmpresaController::class, 'create'])->name('empresa.create');
Route::get('/createUsuario', [App\Http\Controllers\UsuarioController::class, 'create'])->name('usuario.create');
Route::get('/createEndereco', [App\Http\Controllers\EnderecoController::class, 'create'])->name('endereco.create');

//Store
Route::post('/storeEmpresa', [App\Http\Controllers\EmpresaController::class, 'store'])->name('empresa.store');
Route::post('/storeEndereco', [App\Http\Controllers\EnderecoController::class, 'store'])->name('endereco.store');
Route::post('/storeUsuario', [App\Http\Controllers\UsuarioController::class, 'store'])->name('usuario.store');


//listar
Route::get('/listarEndereco', [App\Http\Controllers\EnderecoController::class, 'index'])->name('endereco.index');
Route::get('/listarUsuario', [App\Http\Controllers\UsuarioController::class, 'index'])->name('usuario.index');
Route::get('/listarEmpresa', [App\Http\Controllers\EmpresaController::class, 'index'])->name('empresa.index');

