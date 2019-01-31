<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Registro;
use Illuminate\Http\Request;

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

        return view('rematricula.coords.index')->with([
            'semestres' => $semestres,
            'situacoes' => $situacoes
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

        $query = new Aluno();

        $query = $query->whereHas('registros', function ($query) use ($semestre) {
            if ($semestre !== false) {
                return $query->where('semestre', $semestre);
            }
        });

        $query = $query->when($search, function ($query, $search) {

            return $query->where(function ($query) use ($search) {

                $query->nome($search)->curso($search)->situacao($search);
            });
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

        $result = $query->orderBy('CR', 'DESC')->offset($offset)->limit($limit)->get();
        $registros = [];

        foreach ($result as $resultado) {
            $situacao = 'Erro';
            $avaliacao = 'Não avaliado';
            foreach ($resultado->registros as $registro) {
                $situacao = $registro->situacoes->nome;
                if ($registro->semestre == $semestre and $registro->avaliacao !== 0) {
                    $avaliacao = 'Avaliado';
                }
            }
            array_push($registros, [
                'id' => $resultado->id,
                'nome' => $resultado->nome,
                'curso' => $resultado->curso->nome,
                'cr' => sprintf("%1.4f", $resultado->CR),
                'avaliacao' => $avaliacao,
                'situacao' => $situacao
            ]);
        }

        $resposta = array(
            'total' => $total,
            'count' => $result->count(),
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
}
