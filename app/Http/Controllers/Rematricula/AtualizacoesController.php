<?php

namespace App\Http\Controllers\Rematricula;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use League\Csv\Reader;

class AtualizacoesController extends Controller
{
    public function updateCr(Request $request)
    {
        $validateData = $request->validate([
            'arquivo' => 'required'
        ]);

        $csv = Reader::createFromPath($validateData['arquivo']->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $fileLines = new Collection($csv->jsonSerialize());

        foreach ($fileLines as $fileLine) {

            try {
                $aluno = Aluno::where('matricula', $fileLine['matricula'])->firstOrFail();
                $aluno->CR = $fileLine['cr'];
                $aluno->save();

            } catch (\Exception $e) {
                toastr($e->getMessage(), 'error');
            }
        }
        toastr('CRs atualizado com sucesso', 'success');

        return redirect()->route('sigea.registros.index');
    }

    public function updateMatriculas(Request $request)
    {
        $validateData = $request->validate([
            'arquivo' => 'required'
        ]);

        $csv = Reader::createFromPath($validateData['arquivo']->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv as $line) {
            try {
                $student = Student::updateOrCreate(
                    ['cpf' => $line['cpf']],
                    [
                        'name' => $line['nome_estudante'],
                        'email' => $line['email'],
                        'born' => $this->converterDataBd($line['data_nascimento'])
                    ]
                );

                $course = Course::firstOrCreate(['nome' => $line['curso']]);

                $student->matriculas()->updateOrCreate(
                    ['id' => $line['matricula']],
                    [
                        'status' => $line['situacao'],
                        'course_id' => $course->id
                    ]
                );

            } catch (\Exception $exception) {
                toastr($exception->getMessage(), 'error');
            }
        }

        toastr('Informações das matrículas atualizadas', 'success');
        return redirect()->route('sigea.registros.index');
    }

    private function converterDataBd($data)
    {
        $retorno = Carbon::createFromFormat('d/m/Y', $data);

        return $retorno->format('Y-m-d');
    }
}
