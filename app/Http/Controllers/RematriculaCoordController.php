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

        $query = new Aluno();

        $query = $query->has('registros');

        $query = $query->when($search, function ($query, $search){

            return $query->where(function($query) use ($search){

                $query->nome($search)->curso($search)->situacao($search);
            });
        });

        if ($sort) {
            if ($sort == 'curso') {

                $query = $query->orderBy('id_curso', $request->get('order'));

            }elseif ($sort == 'situacao') {

                $query = $query->with('registros')->orderBy('situacao', $request->get('order'));
            }else{

                $query = $query->orderBy($sort, $request->get('order'));
            }
        }

        $result = $query->orderBy('CR', 'DESC')->offset($offset)->limit($limit)->get();
        $registros = [];

        foreach ($result as $resultado) {
            $situacao = 'Erro';
            $avaliacao = 'Não avaliado';
            foreach ($resultado->registros as $registro) {
                $situacao = $registro->situacoes->nome;
                if ($registro->avaliacao !== 0) {
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
            'total' => $query->count(),
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
