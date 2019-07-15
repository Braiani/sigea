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
    Route::get('/cerel/comprovante/{aluno}', 'Rematricula\CerelController@comprovante')->name('registros.comprovante');
    Route::post('/cerel/registros/get_alunos', 'Rematricula\CerelController@getAlunos')->name('registros.getAlunos');
    Route::get('/cerel/registros/{aluno}/editar', 'Rematricula\CerelController@editar')->name('registros.editar');
    Route::put('/cerel/registros/{aluno}/salvar', 'Rematricula\CerelController@salvarUpdate')->name('registros.salvarUpdate');
    Route::resource('/cerel/registros', 'Rematricula\CerelController')->except(['create', 'store']);

    // Rematrícula - Histórico Escolar, CR e IDs
    Route::post('/cerel/historico_escolar', 'Rematricula\HistoricoEscolarController@update')->name('historicos.update');
    Route::post('/cerel/atualizar_cr', 'Rematricula\AtualizacoesController@updateCr')->name('atualizar.cr');
    Route::post('/cerel/atualizar_matriculas', 'Rematricula\AtualizacoesController@updateMatriculas')->name('atualizar.matriculas');

    // Rematrícula - Coords
    Route::get('/rematricula/coordenacao/table/json', 'Rematricula\RematriculaCoordController@getData')->name('coordenacao.table');
    Route::get('/rematricula/coordenacao/relatorio', 'Rematricula\RematriculaCoordController@geraRelatorio')->name('coordenacao.relatorio');
    Route::put('/rematricula/coordenacao/{aluno}/aceitar/{registro}', 'Rematricula\RematriculaCoordController@aceitar')->name('coordenacao.aceitar');
    Route::put('/rematricula/coordenacao/{aluno}/recusar/{registro}', 'Rematricula\RematriculaCoordController@recusar')->name('coordenacao.recusar');
    Route::put('/rematricula/coordenacao/{aluno}/desfazer/{registro}', 'Rematricula\RematriculaCoordController@desfazer')->name('coordenacao.desfazer');
    Route::resource('rematricula/coordenacao', 'Rematricula\RematriculaCoordController')->only(['index', 'show']);

    //Rotas para Módulo Confirmação de Inscrições
    Route::resource('/confirmacao', 'ConfirmacaoController')->except(['show']);
    Route::get('/confirmacao/table', 'ConfirmacaoController@getData')->name('confirmacao.table');
    Route::get('/confirmacao/relatorio', 'ConfirmacaoRelatorioController@index')->name('confirmacao.relatorio.index');
    Route::post('/confirmacao/relatorio/{edital}', 'ConfirmacaoRelatorioController@gerarFile')->name('confirmacao.relatorio.post');
    Route::post('/confirmacao/relatorio/{edital}/checar', 'ConfirmacaoRelatorioController@checarLista')->name('confirmacao.relatorio.checar');

    // Rotas para Módulo de Matrícula de alunos novos
    Route::resource('/matriculas', 'MatriculaController')->only(['index', 'store']);
    Route::get('/matriculas/relatorios', 'MatriculaController@relatorios')->name('matriculas.relatorios');

    Route::group(['prefix' => 'matriculas/api'], function () {
        Route::post('candidato/reclassificacao', 'MatriculaController@reclassificacao')->name('matriculas.reclassificacao');
        Route::get('candidatos', 'MatriculaController@getCandidatos')->name('matriculas.candidatos');
        Route::get('relatorios/matriculados', 'MatriculaController@getRelatorioMatriculas')->name('matriculas.relatorio.matriculados');
        Route::get('/cota', 'MatriculaController@getcota')->name('matriculas.cota');
        Route::get('/relatorios/listar', 'MatriculaController@getListaMatriculados')->name('matriculas.relatorio.lista');
        Route::post('/relatorios/deferido', 'MatriculaController@matriculaDeferido')->name('matriculas.analise.deferido');
        Route::post('/relatorios/indeferido', 'MatriculaController@matriculaIndeferido')->name('matriculas.analise.indeferido');
        Route::post('/relatorios/matricular', 'MatriculaController@matricular')->name('matriculas.analise.matricular');
    });
});


Route::group(['prefix' => 'backend'], function () {
    Voyager::routes();
});
