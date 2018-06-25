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

Route::get('/', 'DashboardController@index');

Route::get('/admin/login', 'Auth\\LoginController@index')->name('login');
Route::post('/admin/logout', 'Auth\\LoginController@logout')->name('sigea.logout');

Route::get('/admin/lockscreen', 'LockscreenController@lock')->name('lockscreen');
Route::post('/admin/lockscreen', 'LockscreenController@unlock')->name('unlock');

Route::group(['prefix' => 'admin', 'middleware' => 'lock', 'as' => 'sigea.'], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/perfil', 'ProfileController@index')->name('profile.index');
    Route::get('/perfil/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('/perfil', 'ProfileController@update')->name('profile.update');

    Route::get('/passivo/table/json', 'PassivoController@getData')->name('passivo.table');
    Route::resource('/passivo', 'PassivoController')->only(['index', 'store', 'update', 'destroy']);

    Route::get('/mensagens/unread/{id}', 'MensagemController@unread')->name('mensagens.unread');
    Route::get('/mensagens/saida', 'MensagemController@saida')->name('mensagens.saida');
    Route::resource('/mensagens', 'MensagemController')->except(['edit']);

    Route::get('/tasks/users', 'TaskController@getUsers')->name('tasks.getUsers');
    Route::resource('/tasks', 'TaskController')->only(['store', 'update', 'destroy']);

    Route::get('/configuracoes', 'ConfiguracoesController@index')->name('configuracoes.index');
    Route::post('/configuracoes', 'ConfiguracoesController@store')->name('configuracoes.update');
});


Route::group(['prefix' => 'backend'], function () {
    Voyager::routes();
});
