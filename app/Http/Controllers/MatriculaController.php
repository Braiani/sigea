<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Traits\BackendVerification;
use App\Candidato;
use App\CotaMatricula;
use App\StatusMatricula;
use App\DocumentoMatricula;
use App\Pendencia;
use App\Jobs\SendEmailMatricula;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendEmailAtualizacaoMatricula;
use App\Jobs\SendEmailAnalisadoMatricula;

class MatriculaController extends VoyagerBaseController
{
    use BackendVerification;
    
    public function index(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::index($request);
        }
        return view('matriculas.index');
    }
    
    public function store(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::store($request);
        }
        
        // Validar os campos vindos do formulário
        $validateData = $request->validate([
            'id' => 'required',
            'nome' => 'required',
            'email' => 'required|email'
        ]);
        
        $candidato = Candidato::find($validateData['id']);
        
        $status = $candidato->cotaIngresso->analise_renda ? StatusMatricula::emAnalise()->first() : StatusMatricula::matriculado()->first();
        
        $candidato->status()->associate($status->id);
        $candidato->user_id = Auth::user()->id;
        $candidato->nome = $validateData['nome'];
        $candidato->email = $validateData['email'];
        
        $candidato->save();
        
        $documentosNecessarios = $candidato->cotaIngresso->documentos->mapToGroups(function ($item, $key) {
            return [$item['descricao']];
        })->toArray();
        $documentosApresentados = $request->documentos;
        
        $pendencias = array_diff($documentosNecessarios[0], $documentosApresentados);
        $syncData = [];
        
        foreach ($pendencias as $pendencia) {
            $documento = DocumentoMatricula::where('descricao', $pendencia)->first();
            array_push($syncData, [
                'documento_matricula_id' => $documento->id,
                'user_id' => Auth::user()->id
            ]);
        }
        
        $candidato->pendencias()->sync($syncData);
        
        // Cahama a classe responsável por enviar o e-mail aos candidatos
        dispatch(new SendEmailMatricula($candidato));
        
        toastr()->success('Matrícula registrada com sucesso!');
        return redirect()->route('sigea.matriculas.index');
    }
    
    public function relatorios()
    {
        return view('matriculas.relatorio');
    }
    
    public function getListaMatriculados(Request $request)
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search') ? $request->get('search') : false;
        $sort = $request->get('sort') ? $request->get('sort') : false;
        
        $query = new Candidato();
        
        $query = $query->whereHas('status');
        
        if ($search) {
            $query = $query->where(function ($query) use ($search) {
                $query->orWhere('nome', 'LIKE', "%{$search}%")
                    ->orWhereIn('curso_id', function ($query) use ($search) {
                        $query->select('id')->from('cursos')->where('nome', 'LIKE', "%{$search}%");
                    })
                    ->orWhereIn('cota_candidato', function ($query) use ($search) {
                        $query->select('id')->from('cota_matriculas')->where('sigla', 'LIKE', "%{$search}%");
                    })
                    ->orWhereIn('cota_ingresso', function ($query) use ($search) {
                        $query->select('id')->from('cota_matriculas')->where('sigla', 'LIKE', "%{$search}%");
                    })
                    ->orWhereIn('status_matricula_id', function ($query) use ($search) {
                        $query->select('id')->from('status_matriculas')->where('descricao', 'LIKE', "%{$search}%");
                    })
                    ->orWhereIn('user_id', function ($query) use ($search) {
                        $query->select('id')->from('users')->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhere('observacao', 'LIKE', "%{$search}%");
            });
        }
        if ($sort) {
            $query = $query->orderBy($sort, $request->get('order'));
        }
        
        $total = $query->count();
        
        $candidatos = $query->offset($offset)->limit($limit)->orderBy('id', 'DESC')
                        ->with([
                            'status',
                            'cotaCandidato',
                            'cotaIngresso',
                            'curso',
                            'servidor'
                        ])->get();


        $resposta = array(
            'total' => $total,
            'count' => $candidatos->count(),
            'rows' => $candidatos,
        );
        return $resposta;
    }
    
    public function matriculaDeferido(Request $request)
    {
        $validateData = $request->validate(['id' => 'required']);
        
        $candidato = Candidato::find($validateData['id']);
        $status = StatusMatricula::deferido()->first();
        
        $candidato->status()->associate($status->id);
        $candidato->save();

        dispatch(new SendEmailAtualizacaoMatricula($candidato));
        
        return [
            'error' => false,
            'message' => 'Status atualizado com sucesso!'
        ];
    }
    
    public function matriculaIndeferido(Request $request)
    {
        $validateData = $request->validate(['id' => 'required']);
        
        $candidato = Candidato::find($validateData['id']);
        $status = StatusMatricula::indeferido()->first();
        
        $candidato->status()->associate($status->id);
        $candidato->save();

        dispatch(new SendEmailAtualizacaoMatricula($candidato));
        
        return [
            'error' => false,
            'message' => 'Status atualizado com sucesso!'
        ];
    }
    
    public function matricular(Request $request)
    {
        $validateData = $request->validate(['id' => 'required']);
        
        $candidato = Candidato::find($validateData['id']);
        $status = StatusMatricula::matriculado()->first();
        
        $candidato->status()->associate($status->id);
        $candidato->save();

        dispatch(new SendEmailAnalisadoMatricula($candidato));
        
        return [
            'error' => false,
            'message' => 'Matrícula realiada com sucesso!'
        ];
    }

    public function getCandidatos(Request $request)
    {
        $term = trim($request->q);
        $candidatos = Candidato::where('nome', 'LIKE', "%{$term}%")
                        ->orWhere('cpf', 'LIKE', "%{$term}%")
                        ->with('cotaCandidato')
                        ->with('cotaIngresso')
                        ->get();
        $response = [];

        foreach ($candidatos as  $candidato) {
            $text = 'Nome: ' . $candidato->nome . ' - CPF: ' . $candidato->cpf . ' - Curso: ' . $candidato->curso->nome . ' ('.$candidato->periodo.')';

            $response[] = [
                'id' => $candidato->id,
                'text' => $text,
                'candidato' => $candidato
            ];
        }
        return \Response::json($response);
    }
    
    public function getRelatorioMatriculas(Request $request)
    {
        return StatusMatricula::has('candidatos')->with('candidatos')->get();
    }
    
    public function getCota(Request $request)
    {
        return CotaMatricula::with('documentos')->find($request->id);
    }
    
    public function reclassificacao(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required',
            'observacao' => 'required'
        ]);
        
        $candidato = Candidato::find($validateData['id']);
        $status = StatusMatricula::select('id')->reclassificado()->first();

        $candidato->status_matricula_id = $status->id;
        $candidato->user_id = Auth::user()->id;
        $candidato->observacao = $validateData['observacao'];
        
        $candidato->save();

        return [
            'error' => false,
            'message' => 'Reclassificação salva com sucesso!'
        ];
    }
}
