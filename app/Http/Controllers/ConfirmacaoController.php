<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProcessoSeletivo;
use Illuminate\Support\Facades\Validator;
use App\Confirmacao;

class ConfirmacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $editais = ProcessoSeletivo::all();
        if ($request->has('edital')) {
            $confirmacoes = Confirmacao::where('processo_seletivo_id', $request->edital)->get();
        } else {
            $confirmacoes = Confirmacao::all();
        }
        
        return view('confirmacao.index')->with([
            'confirmacoes' => $confirmacoes,
            'editais' => $editais
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $editais = ProcessoSeletivo::all();
        return view('confirmacao.edit-add')->with(['editais' => $editais]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'cpf' => 'required|regex:/([0-9]{3}[.]){2}([0-9]{3}[-]){1}([0-9]{2})/',
            'nome' => 'required|string',
            'processo_seletivo_id' => 'required|numeric'
        ]);
        if ($validate->fails()) {
            toastr()->error('Por favor, verifique as informações!');
            return redirect()->back()
                    ->withInput()
                    ->withErrors($validate);
        }
        
        Confirmacao::create($request->all());

        toastr()->success('Confirmação de inscrição salva com sucesso!');
        return redirect()->route('sigea.confirmacao.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editais = ProcessoSeletivo::all();
        $resposta = [];
        if ($id == 2) {
            $resposta = [
                'nome' => 'Felipe Gustavo',
                'cpf' => '038.925.001-50',
                'processo_seletivo_id' => '1',
                'id' => $id
            ];
        }
        return view('confirmacao.edit-add')->with([
            'confirmacao' => $resposta,
            'editais' => $editais
            ]);
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
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
