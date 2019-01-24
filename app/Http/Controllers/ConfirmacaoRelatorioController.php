<?php

namespace App\Http\Controllers;

use App\Models\ProcessoSeletivo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use League\Csv\Writer;

class ConfirmacaoRelatorioController extends Controller
{
    public function index(Request $request)
    {
        $edital = ProcessoSeletivo::find($request->edital);
        return view('confirmacao.relatorios.index')->withEdital($edital);
    }

    public function gerarFile(Request $request, ProcessoSeletivo $edital)
    {
        $validateData = $request->validate([
            'arquivo' => 'required'
        ]);

        if ($validateData['arquivo']->getClientMimeType() !== 'text/csv') {
            return redirect()->back()->with('error', 'Arquivo anexado não é um CSV');
        }

        $csv = Reader::createFromPath($validateData['arquivo']->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $fileLines = new Collection($csv->jsonSerialize());
        $respota = [];

        foreach ($edital->confirmados as $confirmado) {
            $cpf = str_replace('.', '', $confirmado->cpf);
            $cpf = str_replace('-', '', $cpf);
            $fileLine = $fileLines->firstWhere('CPF', $cpf);
            if ($fileLine !== null) {
                $temp['nome'] = strtoupper($confirmado->nome);
                $temp['inscricao'] = $fileLine['Inscrição'];
                $temp['data'] = $confirmado->created_at->format('d/m/Y H:i:s');
                $temp['publico'] = $fileLine['Público'];

                array_push($respota, $temp);
            } elseif ($request->has('inconsistencias') and $request->inconsistencias) {
                $temp['nome'] = strtoupper($confirmado->nome);
                $temp['inscricao'] = '---';
                $temp['data'] = $confirmado->created_at->format('d/m/Y H:i:s');
                $temp['publico'] = '---';

                array_push($respota, $temp);
            }
        }

        $writer = Writer::createFromFileObject(new \SplTempFileObject());

        $writer->insertOne(['Nome', 'Nº Inscrição', 'Data confirmação', 'Público']);

        $writer->insertAll($respota);

        return $writer->output('Inscrições confirmadas.csv');
    }

    public function checarLista(Request $request, ProcessoSeletivo $edital)
    {

        $validateData = $request->validate([
            'arquivo' => 'required'
        ]);

        if ($validateData['arquivo']->getClientMimeType() !== 'text/csv') {
            return response()->json([
                'error' => true,
                'message' => 'Arquivo anexado não é um CSV'
            ]);
        }

        $csv = Reader::createFromPath($validateData['arquivo']->getPathname(), 'r');
        $csv->setHeaderOffset(0);

        $fileLines = new Collection($csv->jsonSerialize());
        $respota = [];

        foreach ($edital->confirmados as $confirmado) {
            $cpf = str_replace('.', '', $confirmado->cpf);
            $cpf = str_replace('-', '', $cpf);
            $fileLine = $fileLines->firstWhere('CPF', $cpf);
            if ($fileLine === null) {
                $temp['nome'] = strtoupper($confirmado->nome);
                $temp['cpf'] = $confirmado->cpf;
                $temp['data'] = $confirmado->created_at->format('d/m/Y H:i:s');

                array_push($respota, $temp);
            }
        }

        return json_encode($respota);
    }
}
