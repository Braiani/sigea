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

Route::group(['prefix' => 'testes'], function (){
    Route::post('login', 'Api\\LoginController');
    Route::get('qse/{cpf}', 'Api\\RematriculaController@getQse');
    Route::get('token', function(){
        return "Retorno da API";
    });
});
