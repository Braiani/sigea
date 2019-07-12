<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiUpdateEmailRequest;
use App\Models\Matricula;
use App\Models\Subject;
use Illuminate\Http\Request;

class RematriculaController extends Controller
{
    public function updateEmail(ApiUpdateEmailRequest $request)
    {
        $student = $request->user();

        $student->update([
            'email' => $request->email
        ]);

        $student->load(['matriculas', 'matriculas.course']);

        return $student;
    }

    public function intentions(Request $request, Matricula $matricula)
    {
        return $matricula->load('intentions');
    }

    public function registerIntention(Request $request, Matricula $matricula)
    {
        $disciplinas = $request->disciplinas;

        foreach ($disciplinas as $disciplina) {
            $unidade = Subject::firstOrCreate(['nome' => str_replace('*', '', $disciplina)]);

            $matricula->intentions()->attach([
                $unidade->id => [
                    'semestre' => '20192'
                ]
            ]);
        }

        return $matricula->load('intentions');
    }
}
