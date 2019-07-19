<?php

namespace App\Http\Controllers\Rematricula;

use App\Models\Course;
use App\Models\Intention;
use App\Models\Matricula;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RematriculaOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semestres = Intention::select('semestre')->distinct('semestre')->get();
        $courses = Course::all();

        return view('rematricula.cerel.index', compact('semestres', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matricula = Matricula::where('id', $id)->withAndWhereHas('intentions', function ($query) {
            $query->where('semestre', '20192');
        })->with(['course', 'student'])->firstOrFail();

        $token = sha1('IFMS' . $id);
        $url = "https://academico.ifms.edu.br/administrativo/historico_escolar/integralizacao_publica/{$id}/?token={$token}";
        $streamSSL = stream_context_create(array(
            "ssl"=>array(
                "verify_peer"=> false,
                "verify_peer_name"=> false
            )
        ));

        $response =  file_get_contents($url, false, $streamSSL);

        $integralizacao = collect(json_decode($response, true)['Integralizacao']);

        foreach ($integralizacao as $disciplinas) {
            foreach ($disciplinas as $disciplina) {
                if ($disciplina['situacao'] === "Reprovação") {
                    foreach ($matricula->intentions as $intention) {
                        if (strcmp(trim(mb_strtolower(str_replace('*', '', $disciplina['uc_nome']))), mb_strtolower($intention->nome)) == 0){
                            $matricula->intentions()->updateExistingPivot($intention->id, ['avaliacao_coord' => true]);
                            $matricula->load('intentions');
                        }

                    }
                }
            }
        }

        return view('rematricula.cerel.edit', compact('matricula', 'integralizacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Matricula $matricula)
    {
        $matricula->load('intentions');
        $intentionsId = $matricula->intentions->pluck('id')->toArray();

        foreach ($intentionsId as $intentionId) {
            $matricula->intentions()->updateExistingPivot($intentionId, ['avaliado_cerel' => true]);
        }

        toastr('Registrado com sucesso');

        return redirect()->route('sigea.rematricula.show', $matricula->id);
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->has('search') ? $request->get('search') : false;
        $sort = $request->has('sort') ? $request->get('sort') : false;
        $curso = $request->has('curso') ? $request->get('curso') : false;

        $intentions = new Matricula();

        $intentions = $intentions->has('intentions');

        $intentions = $intentions->when($curso, function ($query) use ($curso) {
            $query->whereHas('course', function ($q) use ($curso) {
                $q->where('id', $curso);
            });
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

        $registros = $intentions->offset($offset)->limit($limit)->with(['course', 'intentions', 'student'])->orderBy('id', 'desc')->get();

        $resposta = array(
            'total' => $total,
            'count' => $intentions->count(),
            'rows' => $registros,
        );
        return $resposta;
    }

    public function updateDp(Request $request, Matricula $matricula, Intention $intention)
    {
        $matricula->intentions()->updateExistingPivot($intention->id, ['avaliacao_coord' => true]);

        toastr('Registrado como DP', 'success');

        return redirect()->route('sigea.rematricula.show', $matricula->id);
    }
}
