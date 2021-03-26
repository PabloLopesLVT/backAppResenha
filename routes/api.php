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


//Store
Route::post('/storeUsuario', [App\Http\Controllers\api\UsuarioApiController::class, 'store']);

//Deletar
Route::get('/destroyUsuario/{id}', [App\Http\Controllers\api\UsuarioApiController::class, 'destroy']);
