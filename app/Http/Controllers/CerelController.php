<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Aluno;
use App\Registro;
use App\DisciplinaCurso;

class CerelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alunos = Aluno::orderBy('nome', 'ASC')->get();
        return view('registros.index')->with(['alunos' => $alunos]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Registro::alunoRegistrado($id)->count() > 0) {
            return redirect()->route('sigea.registros.edit', $id);
        }
        $aluno = Aluno::find($id);
        $contadorSemestre = DisciplinaCurso::cursoDisciplina($aluno->curso->id)->max('semestre');
        for ($i=1; $i <= $contadorSemestre; $i++) {
            $disciplinas[$i] = DisciplinaCurso::cursoDisciplina($aluno->curso->id)->semestre($i)->get();
        }

        return view('registros.registrar')->with([
            'aluno' => $aluno,
            'disciplinas' => $disciplinas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aluno = Aluno::find($id);
        $registros = Registro::alunoRegistrado($id)->get();
        return view('registros.mostrar')->with([
            'aluno' => $aluno,
            'registros' => $registros
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'situacao' => 'required',
            'semestre' => 'required',
            'disciplinas' => 'required'
        ]);
        $semestre = $request->semestre;
        $situacao = $request->situacao;
        $disciplinas = $request->disciplinas;

        foreach ($disciplinas as $disciplina) {
            $registro = new Registro();
            $registro->id_disciplina_cursos = $disciplina;
            $registro->id_alunos = $id;
            $registro->semestre = $semestre;
            $registro->situacao = $situacao;
            $registro->id_user = $request->user()->id;
            $registro->avaliacao = 0; // Avaliação => 0 = Não avaliado; 1 = Avaliado e aceito; 2 = Avaliado e não aceito;

            $registro->save();
        }

        toastr()->success('Registro realizado com sucesso!');
        return redirect()->route('sigea.registros.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Registro $registro)
    {
        try{
            $this->authorize('delete', $registro);
        }catch(\Exception $e){
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.registros.edit', $registro);
        }
        $aluno = $registro->aluno->id;
        $registro->delete();

        toastr()->success('Disciplina removida com sucesso!');

        return redirect()->route('sigea.registros.edit', $aluno);
    }

    public function comprovante(Request $request, Aluno $aluno)
    {
        $registros = Registro::AlunoRegistrado($aluno->id)->get();

        return PDF::loadView('registros.comprovante', [
            'aluno' => $aluno,
            'registros' => $registros
        ])->stream();

        // return view('registros.comprovante')->with([
        //     'aluno' => $aluno,
        //     'registros' => $registros]
        // );
    }

    public function editar(Request $request, Aluno $aluno)
    {
        $registros = Registro::alunoRegistrado($aluno->id)->get();
        $contadorSemestre = DisciplinaCurso::cursoDisciplina($aluno->curso->id)->max('semestre');
        for ($i=1; $i <= $contadorSemestre; $i++) {
            $disciplinas[$i] = DisciplinaCurso::cursoDisciplina($aluno->curso->id)->semestre($i)->get();
        }

        return view('registros.alterar')->with([
            'aluno' => $aluno,
            'disciplinas' => $disciplinas,
            'registros' => $registros
        ]);
    }

    public function salvarUpdate(Request $request, Aluno $aluno)
    {
        $request->validate([
            'situacao' => 'required',
            'semestre' => 'required',
            'disciplinas' => 'required'
        ]);
        $semestre = $request->semestre;
        $situacao = $request->situacao;
        $disciplinas = $request->disciplinas;

        foreach ($disciplinas as $disciplina) {
            if (Registro::disciplinaRegistrada($disciplina)->alunoRegistrado($aluno->id)->count() == 0) {
                $registro = new Registro();
                $registro->id_disciplina_cursos = $disciplina;
                $registro->id_alunos = $aluno->id;
                $registro->semestre = $semestre;
                $registro->situacao = $situacao;
                $registro->id_user = $request->user()->id;
                $registro->avaliacao = 0; // Avaliação => 0 = Não avaliado; 1 = Avaliado e aceito; 2 = Avaliado e não aceito;

                $registro->save();
            }
        }

        toastr()->success('Registro atualizado com sucesso!');
        return redirect()->route('sigea.registros.edit', $aluno);
    }

    public function getAlunos(Request $request)
    {
        $alunos = Aluno::where('nome', 'LIKE', "%{$request->q}%")->get();
        $resposta = [];
        foreach ($alunos as $aluno) {
            $resposta[] = [
                'text' => $aluno->nome,
                'value' => $aluno->id,
                'data' => [
                    'subtext' => $aluno->curso->nome
                ]
            ];
        }


        return $resposta;
    }
}
