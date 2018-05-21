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
    return redirect()->route('sigea.dashboard');
});

Route::get('/admin/login', 'Auth\\LoginController@index')->name('login');
Route::post('/admin/logout', 'Auth\\LoginController@logout')->name('sigea.logout');

Route::get('/admin/lockscreen', 'LockscreenController@lock')->name('lockscreen');
Route::post('/admin/lockscreen', 'LockscreenController@unlock')->name('unlock');

Route::group(['prefix' => 'admin', 'middleware' => 'lock'], function(){
    Route::get('/', function(){ return view('dashboard'); })->name('sigea.dashboard');
    Route::get('/perfil', 'ProfileController@index')->name('sigea.profile.index');
    Route::get('/perfil/edit', 'ProfileController@edit')->name('sigea.profile.edit');
    Route::put('/perfil', 'ProfileController@update')->name('sigea.profile.update');
    Route::get('/passivo', function(){return 'teste';})->name('passivo');
    Route::get('/configuracoes', function(){return 'teste';})->name('configuracoes');
});


Route::group(['prefix' => 'backend'], function () {
    Voyager::routes();
});
