<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Curso;
use App\Models\DisciplinaCurso;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Csv\Reader;

class HistoricoEscolarController extends Controller
{
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'arquivo' => 'required'
        ]);

        $csv = Reader::createFromPath($validateData['arquivo']->getPathname(), 'r');
        $csv->setHeaderOffset(0);


        foreach ($csv as $key => $fileLine) {
            /*dd($fileLine);*/

            try {
                $curso = Curso::where('nome', $fileLine['curso'])->firstOrFail();
                $disciplina = DisciplinaCurso::where('nome', 'LIKE', "{$fileLine['disciplina']}%")
                    ->where('id_cursos', $curso->id)
                    ->firstOrFail();

                $aluno = Aluno::firstOrCreate(
                    ['matricula' => $fileLine['matricula']],
                    [
                        'nome' => $fileLine['estudante'],
                        'id_curso' => $curso->id,
                        'CR' => 0,
                    ]
                );

                $filtered = $aluno->historico->firstWhere('id', $disciplina->id);

                if ($filtered === null) {
                    $disciplina->carga_horaria = $fileLine['carga_horaria'];
                    $disciplina->save();
                }

                $sync_data = [];

                foreach ($aluno->historico as $key => $historico) {
                    if ($filtered !== null and $filtered->id === $historico->id) {
                        if ($historico->pivot->status !== "Aprovado por Nota" and $fileLine['status'] === "Aprovado por Nota"){
                            array_push($sync_data, [
                                'disciplina_curso_id' => $historico->id,
                                'status' => $fileLine['status']
                            ]);
                        }else{
                            array_push($sync_data, [
                                'disciplina_curso_id' => $historico->id,
                                'status' => $historico->pivot->status
                            ]);
                        }
                    } else {
                        array_push($sync_data, [
                            'disciplina_curso_id' => $historico->id,
                            'status' => $historico->pivot->status
                        ]);
                    }
                }

                if ($filtered === null){
                    array_push($sync_data, [
                        'disciplina_curso_id' => $disciplina->id,
                        'status' => $fileLine['status']
                    ]);
                }

                $aluno->historico()->sync($sync_data);

            } catch (ModelNotFoundException $modelException) {
                toastr($modelException->getMessage(), 'error', 'Erro!');
                continue;
            }

        }

        toastr('Históricos importados!', 'success');
        return redirect()->route('sigea.registros.index');
    }
}
