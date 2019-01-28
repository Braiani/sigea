<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProcessoSeletivo;
use Illuminate\Support\Facades\Validator;
use App\Models\Confirmacao;

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
        $confirmacoes = [];
        
        if ($request->has('edital')) {
            $confirmacoes = Confirmacao::where('processo_seletivo_id', $request->edital)->paginate(10);
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
                
        Confirmacao::updateOrCreate(
            [
            'cpf' => $request->cpf,
            'processo_seletivo_id' => $request->processo_seletivo_id
        ],
            $request->except(['_token', '_method', 'cpf'])
        );

        toastr()->success('Confirmação de inscrição salva com sucesso!');
        return redirect()->route('sigea.confirmacao.index', ['edital' => $request->processo_seletivo_id]);
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
        $confirmacao = Confirmacao::find($id);
        
        return view('confirmacao.edit-add')->with([
            'confirmacao' => $confirmacao,
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
        $confirmacao = Confirmacao::find($id);
        $confirmacao->update($request->except(['_token', '_method']));
        
        toastr()->success('Confirmação de inscrição editada com sucesso!');
        return redirect()->route('sigea.confirmacao.index', ['edital' => $request->processo_seletivo_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $confirmacao = Confirmacao::find($id);
        $confirmacao->delete();

        toastr()->success('Confirmação de inscrição apagada com sucesso!');
        return redirect()->route('sigea.confirmacao.index', ['edital' => $confirmacao->processo_seletivo_id]);
    }

    public function getData(Request $request)
    {
        ///
    }
}
