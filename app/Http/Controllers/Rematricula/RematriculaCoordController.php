<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Registro;
use Illuminate\Http\Request;
use League\Csv\Writer;

class RematriculaCoordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semestres = Registro::select('semestre')->distinct('semestre')->get();
        $situacoes = Registro::select('situacao')->distinct('situacao')->get();
        $cursos = Aluno::select('id_curso')->has('registros')->with('curso')->distinct('curso')->get();

        return view('rematricula.coords.index')->with([
            'semestres' => $semestres,
            'situacoes' => $situacoes,
            'cursos' => $cursos
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $aluno = Aluno::find($id);
        return view('rematricula.coords.mostrar')->with([
            'aluno' => $aluno,
        ]);
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->has('search') ? $request->get('search') : false;
        $sort = $request->has('sort') ? $request->get('sort') : false;
        $semestre = $request->has('semestre') ? $request->get('semestre') : false;
        $situacao = $request->has('situacao') ? $request->get('situacao') : false;
        $curso = $request->has('curso') ? $request->get('curso') : false;

        $query = new Aluno();

        $query = $query->whereHas('registros', function ($query) use ($search, $semestre, $situacao, $curso) {

            $query = $query->when($semestre, function ($query) use ($semestre) {

                return $query->whereSemestre($semestre);

            });

            $query = $query->when($situacao, function ($query) use ($situacao) {

                return $query->whereSituacao($situacao);

            });

            $query = $query->when($curso, function ($query) use ($curso) {

                return $query->whereHas('aluno', function ($query) use ($curso) {
                    return $query->whereIdCurso($curso);
                });

            });

            $query = $query->when($search, function ($query) use ($search) {

                $query = $query->whereHas('aluno', function ($query) use ($search) {
                    return $query->Where('nome', 'LIKE', "%{$search}%")->orWhere('matricula', 'LIKE', "%{$search}%");
                });

            });

            return $query;
        });

        if ($sort) {
            if ($sort == 'curso') {

                $query = $query->orderBy('id_curso', $request->get('order'));

            } elseif ($sort == 'situacao') {

                $query = $query->with('registros')->orderBy('situacao', $request->get('order'));

            } else {

                $query = $query->orderBy($sort, $request->get('order'));
            }
        }

        $total = $query->count();

        $registros = $query->offset($offset)->limit($limit)->orderBy('CR', 'DESC')->with(['curso', 'registros.situacoes'])->get();

        $resposta = array(
            'total' => $total,
            'count' => $registros->count(),
            'rows' => $registros,
        );
        return $resposta;
    }


    public function aceitar(Request $request, Aluno $aluno, Registro $registro)
    {
        try {
            $this->authorize('aceitar', $registro);
        } catch (\Exception $e) {
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.coordenacao.show', $aluno->id);
        }

        $registro->avaliacao = 1;

        $registro->save();

        toastr()->success('Registro aceito!');
        return redirect()->route('sigea.coordenacao.show', $aluno->id);
    }

    public function recusar(Request $request, Aluno $aluno, Registro $registro)
    {
        try {
            $this->authorize('recusar', $registro);
        } catch (\Exception $e) {
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.coordenacao.show', $aluno->id);
        }

        $registro->avaliacao = 2;

        $registro->save();

        toastr()->success('Registro recusado!');
        return redirect()->route('sigea.coordenacao.show', $aluno->id);
    }

    public function desfazer(Request $request, Aluno $aluno, Registro $registro)
    {
        try {
            $this->authorize('desfazer', $registro);
        } catch (\Exception $e) {
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.coordenacao.show', $aluno->id);
        }

        $registro->avaliacao = 0;

        $registro->save();

        toastr()->success('Registro desfeito!');
        return redirect()->route('sigea.coordenacao.show', $aluno->id);
    }

    public function geraRelatorio(Request $request)
    {
        $alunos = Aluno::has('registros')->with('registros')->get();
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        $csv->insertOne(['Estudante', 'Semestre', 'Situação']);

        foreach ($alunos as $aluno) {
            $semestreAnterior = $aluno->registros->firstWhere('semestre', '20182');
            $semestreAtual = $aluno->registros->firstWhere('semestre', '20191');

            $csv->insertOne([
                $aluno->nome,
                '20181',
                $semestreAnterior === null ? '' : $semestreAnterior->situacoes->nome
            ]);
            $csv->insertOne([
                $aluno->nome,
                '20191',
                $semestreAtual === null ? '' : $semestreAtual->situacoes->nome
            ]);
        }

        return $csv->output('relatorio.csv');
    }
}
