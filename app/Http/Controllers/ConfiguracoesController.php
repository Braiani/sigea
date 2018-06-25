<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function index(Request $request)
    {
        return view('configuracoes.index');
    }

    public function store(Request $request)
    {
        if (!$request->sidebar_color) {
            toastr()->error('Ocorreu um erro ao salvar!');
            return redirect()->route('sigea.configuracoes.index');
        }

        $color_sidebar = $request->sidebar_color;

        $user = $request->user();
        $user_settings = $user->settings;

        $user_settings['sidebar_color'] =  $color_sidebar;

        $user->settings = $user_settings;

        $user->save();

        toastr()->success('Configurações salvas!');
        return redirect()->route('sigea.configuracoes.index');
    }
}
