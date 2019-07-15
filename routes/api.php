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

Route::group(['prefix' => 'rematricula'], function (){
    Route::post('login', 'Api\\LoginController');
    Route::group(['prefix' => 'students', 'middleware' => 'auth:api'], function () {
        Route::post('/email/update', 'Api\\RematriculaController@updateEmail');
        Route::get('/intentions/{matricula}', 'Api\\RematriculaController@intentions');
        Route::post('/intentions/{matricula}', 'Api\\RematriculaController@registerIntention');
    });
});

Route::get('testes/intentions', function () {
    return App\Models\Matricula::with(['intentions', 'student'])->first();
});