<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;
use App\Aluno;

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
        $aluno = Aluno::find($id);
        return view('rematricula.coords.mostrar')->with([
            'aluno' => $aluno,
        ]);
    }

    public function getData(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search') ? $request->get('search') : false;
        $sort = $request->get('sort') ? $request->get('sort') : false;

        $total = Registro::select('id_alunos')->distinct()->get()->count();

        $query = new Aluno();

        if ($search) {
            $query = $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhereHas('curso', function($q) use ($search) {
                        $q->where('cursos.nome', 'LIKE', "%{$search}%");
                    });
        }

        if ($sort) {
            if ($sort == 'curso') {

                $query = $query->orderBy('id_curso', $request->get('order'));

            }elseif ($sort == 'situacao') {

                $query = $query->with('registros')->orderBy('situacao', $request->get('order'));
            }else{

                $query = $query->orderBy($sort, $request->get('order'));
            }
        }

        $query = $query->has('registros');

        $result = $query->offset($offset)->limit($limit)->get();

        $registros = [];

        foreach ($result as $resultado) {
            array_push($registros, [
                'id' => $resultado->id,
                'nome' => $resultado->nome,
                'curso' => $resultado->curso->nome,
                'cr' => sprintf("%1.4f", $resultado->CR),
                // 'avaliacao' => $resultado->registros->avaliacao->count() == 0 ? 'Não avaliado' : 'Avaliado',
                'situacao' => $resultado->registros[0]->situacao == 1 ? 'Dependência' : 'Retido'
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
        try{
            $this->authorize('aceitar', $registro);
        }catch(\Exception $e){
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
        try{
            $this->authorize('recusar', $registro);
        }catch(\Exception $e){
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
        try{
            $this->authorize('desfazer', $registro);
        }catch(\Exception $e){
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.coordenacao.show', $aluno->id);
        }

        $registro->avaliacao = 0;

        $registro->save();

        toastr()->success('Registro desfeito!');
        return redirect()->route('sigea.coordenacao.show', $aluno->id);
    }
}
