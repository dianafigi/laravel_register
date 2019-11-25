<?php

use Illuminate\Http\Request;

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

Route::get('/categorias', 'ControladorCategoria@indexJson'); // em vez de retornar view, vai retornar vectores de objectos de JS

Route::resource('/produtos', 'ControladorProduto');


//qq rota feita aqui , vai aparecer no browser c/ '/api/' à frente, ex: www.checaleka/api//produtos