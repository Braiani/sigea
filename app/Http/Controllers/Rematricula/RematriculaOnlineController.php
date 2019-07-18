<?php

namespace App\Http\Controllers\Rematricula;

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

        return view('rematricula.cerel.index', compact('semestres'));
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
        })->with(['course', 'student'])->first();

        $token = sha1('IFMS' . $id);
        $url = "https://academico.ifms.edu.br/administrativo/historico_escolar/integralizacao_publica/{$id}/?token={$token}";
        $streamSSL = stream_context_create(array(
            "ssl"=>array(
                "verify_peer"=> false,
                "verify_peer_name"=> false
            )
        ));

        $response =  file_get_contents($url, false, $streamSSL);

        $integralizacao = collect(json_decode($response))['Integralizacao'];

        return view('rematricula.cerel.edit', compact('matricula', 'integralizacao'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->has('search') ? $request->get('search') : false;
        $sort = $request->has('sort') ? $request->get('sort') : false;

        $intentions = new Matricula();

        $intentions = $intentions->whereHas('intentions', function ($query) use ($search) {
            //
        })->when($search, function ($query) use ($search) {
            $query->where('id', 'LIKE', "%{$search}%");
        });

        $total = $intentions->count();

        $registros = $intentions->offset($offset)->limit($limit)->with(['course', 'student'])->orderBy('id', 'desc')->get();

        $resposta = array(
            'total' => $total,
            'count' => $intentions->count(),
            'rows' => $registros,
        );
        return $resposta;
    }
}
