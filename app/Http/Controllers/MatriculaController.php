<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Traits\BackendVerification;
use App\Candidato;

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
    
    public function getCandidatos(Request $request)
    {
        $term = trim($request->q);
        $candidatos = Candidato::where('nome', 'LIKE', "%{$term}%")
                        ->orWhere('cpf', 'LIKE', "%{$term}%")
                        ->get();
        $response = [];

        foreach ($candidatos as  $candidato) {
            $text = 'Nome: ' . $candidato->nome . ' - CPF: ' . $candidato->cpf . ' - Curso: ' . $candidato->curso->nome . ' ('.$candidato->periodo.')';

            $response[] = [
                'id' => $candidato->id,
                'text' => $text
            ];
        }
        return \Response::json($response);
    }
}
