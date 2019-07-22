<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Intention;
use App\Models\Matricula;
use App\Traits\RetreiveSigaInfo;
use Illuminate\Http\Request;

class RematriculaOnlineCoordsController extends Controller
{
    use RetreiveSigaInfo;

    public function index()
    {
        $semestres = Intention::select('semestre')->distinct('semestre')->get();
        $courses = Course::all();

        return view('rematricula.coords.online.index', compact('semestres', 'courses'));
    }

    public function show(Request $request, Matricula $matricula)
    {
        $matricula->load(['intentions' => function ($q) {
            $q->where('avaliacao_coord', true);
        }, 'student', 'course']);

        return view('rematricula.coords.online.mostrar', compact('matricula'));
    }

    public function aceitar(Request $request, Matricula $matricula, Intention $intention)
    {
        $matricula->intentions()->updateExistingPivot($intention->id, ['avaliado_coord' => 1]);

        toastr('Registro aceito com sucesso.', 'success');
        return redirect()->back();
    }

    public function recusar(Request $request, Matricula $matricula, Intention $intention)
    {
        $matricula->intentions()->updateExistingPivot($intention->id, ['avaliado_coord' => 2]);

        toastr('Registro recusado com sucesso.', 'info');
        return redirect()->back();
    }

    public function desfazer(Request $request, Matricula $matricula, Intention $intention)
    {
        $matricula->intentions()->updateExistingPivot($intention->id, ['avaliado_coord' => 0]);

        toastr('Registro desfeito com sucesso.', 'success');
        return redirect()->back();
    }

    public function updateMatriculaInformations()
    {
        try {
            $matriculas = Matricula::whereHas('intentions', function ($query) {
                $query->where('avaliacao_coord', true)->whereNull('is_retido');
            })->get();

            foreach ($matriculas as $matricula) {
                $response = json_decode($this->getAllMatriculaInfo($matricula->id), true);
                $matricula->update([
                    'cr' => $response['Matricula']['cr'],
                    'is_retido' => $this->verifyCHRetido($response['Integralizacao'])
                ]);
            }

            $resposta = [
                'error' => false,
                'message' => "CRs e Situações atualizadas com sucesso!"
            ];
            return response($resposta);
        }catch (\Exception $exception) {
            $resposta = [
                'error' => true,
                'message' => $exception->getMessage()
            ];
            return response($resposta);
        }
    }

    private function verifyCHRetido($integralizacao)
    {
        $total = 0;

        foreach ($integralizacao as $disciplinas) {
            foreach ($disciplinas as $disciplina) {
                if ($disciplina['situacao'] === "Reprovação") {
                    $total += $disciplina['carga_horaria'];
                }
            }
        }

        return $total > 165;
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->has('search') ? $request->get('search') : false;
        $sort = $request->has('sort') ? $request->get('sort') : false;
        $order = $request->has('order') ? $request->get('order') : false;
        $curso = $request->has('curso') ? $request->get('curso') : false;
        $situacao = $request->has('situacao') ? $request->get('situacao') : false;

        $intentions = new Matricula();

        $intentions = $intentions->whereHas('intentions', function ($q) {
            $q->where('avaliacao_coord', true);
        });

        $intentions = $intentions->when($curso, function ($query) use ($curso) {
            $query->whereHas('course', function ($q) use ($curso) {
                $q->where('id', $curso);
            });
        });

        $intentions = $intentions->when($situacao, function ($query) use ($situacao) {
            $query->where('is_retido', $situacao == 'retido');
        });

        $intentions = $intentions->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhere('id', "LIKE", "%{$search}%")->orWhereHas('course', function ($q) use ($search) {
                    $q->where('nome', 'LIKE', "%{$search}%");
                });
            });
        });

        $total = $intentions->count();

        $registros = $intentions->offset($offset)->limit($limit)->with(['course', 'intentions', 'student'])->orderBy($sort ? $sort : 'id', $order)->get();

        $resposta = array(
            'total' => $total,
            'count' => $intentions->count(),
            'rows' => $registros,
        );
        return $resposta;
    }
}
