<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;

class RematriculaCoordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Registro::all();
        return view('rematricula.coords.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search') ? $request->get('search') : false;
        $sort = $request->get('sort') ? $request->get('sort') : false;

        $total = Registro::count();

        $query = new Registro();

        if ($search) {
            $query = $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('curso', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
        }
        if ($sort) {
            $query = $query->orderBy($sort, $request->get('order'));
        }

        $result = $query->select('id_alunos', 'avaliacao')->distinct()->offset($offset)->limit($limit)->orderBy('id_alunos', 'DESC')->get();
        // $result = $query->offset($offset)->limit($limit)->orderBy('id', 'DESC')->get();

        $registros = [];

        foreach ($result as $resultado) {
            array_push($registros, [
                'nome' => $resultado->aluno->nome,
                'curso' => $resultado->aluno->curso->nome,
                'cr' => sprintf("%1.4f", $resultado->aluno->CR),
                // 'avaliacao' => $resultado->avaliacao
            ]);
        }

        $resposta = array(
            'total' => $total,
            'count' => $result->count(),
            'rows' => $registros,
        );
        return $resposta;
    }
}
