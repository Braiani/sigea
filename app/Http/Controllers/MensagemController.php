<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Mensagem;
use Illuminate\Support\Facades\Auth;
use App\User;

class MensagemController extends VoyagerBaseController
{
    public function __construct()
    {
        $this->middleware('lock');
    }

    public function index(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::index($request);
        }

        $entrada = Mensagem::MailTo($request->user()->id)->latest()->paginate();
        return view('mensagem.index')->with([
            'entrada' => $entrada,
        ]);
    }

    public function show(Request $request, $id)
    {
        if ($this->isBackend($request)) {
            return parent::index($request);
        }

        $mensagem = Mensagem::find($id);

        if ($mensagem->to == $request->user()->id) {
            $mensagem->update(['read' => 1]);
        }

        return view('mensagem.entrada')->with(['mensagem' => $mensagem]);
    }

    public function unread(Request $request, $id)
    {
        if (!$request->ajax()) {
            toastr()->error('Ocorreu um erro ao processar sua solicitação!');

            return redirect()->route('sigea.mensagens.index');
        }
        $mensagem = Mensagem::find($id);

        if ($mensagem->update(['read' => 0])) {
            return [
                'error' => false,
                'message' => 'Mensagem marcada como não lida!'
            ];
        } else {
            return [
                'error' => true,
                'message' => 'Não foi possível executar essa ação!'
            ];
        }

        return $request;
    }

    public function destroy(Request $request, $id)
    {
        if ($this->isBackend($request)) {
            return parent::destroy($request, $id);
        }
        $mensagem = Mensagem::find($id);
        $mensagem->delete();
        return [
            'error' => false,
            'message' => 'Mensagem marcada como não lida!'
        ];
    }

    public function create(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::create($request);
        }
        $usuarios = User::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('mensagem.escrever')->with([
            'usuarios' => $usuarios,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->isBackend($request)) {
            return parent::store($request);
        }

        $request->validate([
            'to' => 'required',
            'titulo' => 'required',
            'mensagem' => 'required'
        ]);

        if (!$request->ajax()) {
            $request->merge([
                'user_id' => $request->user()->id,
            ]);

            if (Mensagem::create($request->all())) {
                toastr()->success('Mensagem enviada com sucesso');

                return redirect()->route('sigea.mensagens.index');
            }

            toastr()->error('Ocorreu um erro ao enviar a mensagem!');

            return redirect()->route('sigea.mensagens.create');
        }
    }

    public function saida(Request $request)
    {
        $mensagens = Mensagem::MailFrom($request->user()->id)->latest()->paginate();

        return view('mensagem.saida')->with([
            'mensagens' => $mensagens,
        ]);
    }

    public function isBackend(Request $request)
    {
        return in_array('backend', explode('/', $request->url()));
    }
}
