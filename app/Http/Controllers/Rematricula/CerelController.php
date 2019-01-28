<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\RegistroSituacao;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Aluno;
use App\Models\Registro;
use App\Models\DisciplinaCurso;

class CerelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('registros.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $registros = Registro::alunoRegistrado($id)->where('semestre', $request->semestre);
        if ($registros->count() === 0) {
            return redirect()->route('sigea.registros.index');
        }
        $aluno = Aluno::find($id);
        $registros = $registros->get();

        return view('registros.mostrar')->with([
            'aluno' => $aluno,
            'registros' => $registros
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return array $response
     */
    public function edit(Request $request, $id)
    {
        $aluno = Aluno::with(['situacao', 'historico'])->find($id);

        $aluno = $this->verificaStatus($aluno);

        $alunoVeridicado = $aluno->fresh('situacao');

        $registros = $alunoVeridicado->registros->where('semestre', $request->semestre);

        return [
            'aluno' => $alunoVeridicado,
            'historico' => $alunoVeridicado->historico,
            'registros' => $registros
        ];
    }

    public function verificaStatus(Aluno $aluno) : Aluno
    {
        $rfs = $aluno->historico->where('pivot.status', "Reprovado por Falta");
        $rns = $aluno->historico->where('pivot.status', "Reprovado por Nota");

        if ($aluno->situacao === null){

            if ($rfs->isNotEmpty() or $rns->isNotEmpty()){
                $sum = 0;
                foreach ($rns as $reprovacao){
                    $sum += $reprovacao['carga_horaria'];
                }
                foreach ($rfs as $reprovacao){
                    $sum += $reprovacao['carga_horaria'];
                }
                if ($sum / 15 < 12){
                    $dependencia = RegistroSituacao::dependencia()->first();
                    $aluno->situacao()->associate($dependencia->id);
                    $aluno->save();
                    return $aluno;
                }else{
                    $retido = RegistroSituacao::retido()->first();
                    $aluno->situacao()->associate($retido->id);
                    $aluno->save();
                    return $aluno;
                }
            }else{
                $regular = RegistroSituacao::regular()->first();
                $aluno->situacao()->associate($regular->id);
                $aluno->save();
                return $aluno;
            }
        }else{
            return $aluno;
        }
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

        $validateData = $request->validate([
            'situacao' => 'required',
            'semestre' => 'required',
            'disciplinas' => 'required'
        ]);

        $semestre = $validateData['semestre'];
        $situacao = $validateData['situacao'];
        $disciplinas = $validateData['disciplinas'];

        if (Registro::alunoRegistrado($id)->where('semestre', $semestre)->count() > 0) {
            return redirect()->route('sigea.registros.editar', [$id, 'semestre' => $semestre]);
        }


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

        $aluno = Aluno::find($id);

        toastr()->success('Registro realizado com sucesso!');
        return redirect()->route('sigea.registros.comprovante', [$aluno, 'semetre' => '20191']);
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
        $request->validate([
            'semestre' => 'required'
        ]);
        $registros = Registro::AlunoRegistrado($aluno->id)->where('semestre', $request->semestre)->get();

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
        $registros = Registro::alunoRegistrado($aluno->id)->where('semestre', $request->semestre)->get();
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
            if (Registro::disciplinaRegistrada($disciplina)->alunoRegistrado($aluno->id)->where('semestre', $semestre)->count() == 0) {
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
        return redirect()->route('sigea.registros.show', [$aluno, 'semestre' => $semestre]);
    }

    public function getAlunos(Request $request)
    {
        $alunos = Aluno::where('nome', 'LIKE', "%{$request->q}%")->with('curso')->get();
        $resposta = [];
        foreach ($alunos as $aluno) {
            $resposta[] = [
                'text' => $aluno->nome . ' - ' . $aluno->curso->nome,
                'id' => $aluno->id,
                'aluno' => $aluno
            ];
        }


        return $resposta;
    }
}
