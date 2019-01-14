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

Route::group(['prefix' => 'admin', 'middleware' => 'lock', 'as' => 'sigea.'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // Rota para o perfil do usuário!
    Route::get('/perfil', 'ProfileController@index')->name('profile.index');
    Route::get('/perfil/edit', 'ProfileController@edit')->name('profile.edit');
    Route::put('/perfil', 'ProfileController@update')->name('profile.update');

    // Rota para o controle do passivo
    Route::get('/passivo/table/json', 'PassivoController@getData')->name('passivo.table');
    Route::get('/passivos/cursos', 'PassivoController@getCursos')->name('passivo.cursos');
    Route::post('/passivos/verifica-nome', 'PassivoController@verificaNome')->name('passivo.verifica');
    Route::resource('/passivos', 'PassivoController')->only(['index', 'store', 'update', 'destroy']);

    // Rota para mensagens do sistema
    Route::get('/mensagens/unread/{id}', 'MensagemController@unread')->name('mensagens.unread');
    Route::get('/mensagens/saida', 'MensagemController@saida')->name('mensagens.saida');
    Route::resource('/mensagens', 'MensagemController')->except(['edit']);

    // Rota para Tarefas
    Route::get('/tasks/users', 'TaskController@getUsers')->name('tasks.getUsers');
    Route::resource('/tasks', 'TaskController')->only(['store', 'update', 'destroy']);

    // Configurações
    Route::get('/configuracoes', 'ConfiguracoesController@index')->name('configuracoes.index');
    Route::post('/configuracoes', 'ConfiguracoesController@store')->name('configuracoes.update');

    // Rematrícula - CEREL
    Route::get('/cerel/comprovante/{aluno}', 'CerelController@comprovante')->name('registros.comprovante');
    Route::post('/cerel/registros/get_alunos', 'CerelController@getAlunos')->name('registros.getAlunos');
    Route::get('/cerel/registros/{aluno}/editar', 'CerelController@editar')->name('registros.editar');
    Route::put('/cerel/registros/{aluno}/salvar', 'CerelController@salvarUpdate')->name('registros.salvarUpdate');
    Route::resource('/cerel/registros', 'CerelController')->except(['create', 'store']);

    // Rematrícula - Coords
    Route::get('/rematricula/coordenacao/table/json', 'RematriculaCoordController@getData')->name('coordenacao.table');
    Route::put('/rematricula/coordenacao/{aluno}/aceitar/{registro}', 'RematriculaCoordController@aceitar')->name('coordenacao.aceitar');
    Route::put('/rematricula/coordenacao/{aluno}/recusar/{registro}', 'RematriculaCoordController@recusar')->name('coordenacao.recusar');
    Route::put('/rematricula/coordenacao/{aluno}/desfazer/{registro}', 'RematriculaCoordController@desfazer')->name('coordenacao.desfazer');
    Route::resource('rematricula/coordenacao', 'RematriculaCoordController')->only(['index', 'show']);
    
    //Rotas para Módulo Confirmação de Inscrições
    Route::resource('/confirmacao', 'ConfirmacaoController')->except(['show']);
    
    // Rotas para Módulo de Matrícula de alunos novos
    Route::resource('/matriculas', 'MatriculaController')->only(['index', 'store']);
    Route::group(['prefix' => 'matriculas/api'], function () {
        Route::post('candidato/reclassificacao', 'MatriculaController@reclassificacao')->name('matriculas.reclassificacao');
        Route::get('candidatos', 'MatriculaController@getCandidatos')->name('matriculas.candidatos');
        Route::get('relatorios/matriculados', 'MatriculaController@getRelatorioMatriculas')->name('matriculas.relatorio.matriculados');
        Route::get('/cota', 'MatriculaController@getcota')->name('matriculas.cota');
    });
});


Route::group(['prefix' => 'backend'], function () {
    Voyager::routes();
});
