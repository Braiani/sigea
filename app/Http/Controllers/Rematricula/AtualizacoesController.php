<?php

namespace App\Http\Controllers\Rematricula;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        foreach ($fileLines as $fileLine){

            try{
                $aluno = Aluno::where('matricula', $fileLine['matricula'])->firstOrFail();
                $aluno->CR = $fileLine['cr'];
                $aluno->save();

            }catch (\Exception $e){
                toastr($e->getMessage(), 'error');
            }
            toastr('CRs atualizado com sucesso', 'success');

            return redirect()->route('sigea.registros.index');
        }
    }
}
