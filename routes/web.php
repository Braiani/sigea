<?php

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
    return redirect()->route('dashboard');
});

Route::get('/admin/login', 'Auth\\LoginController@index')->name('sigea.login');
Route::post('/admin/logout', 'Auth\\LoginController@logout')->name('sigea.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/', function(){
        return view('dashboard');
    })->name('sigea.dashboard');
    Route::get('/passivo', function(){return 'teste';})->name('passivo');
    Route::get('/configuracoes', function(){return 'teste';})->name('configuracoes');
});


Route::group(['prefix' => 'backend'], function () {
    Voyager::routes();
});
