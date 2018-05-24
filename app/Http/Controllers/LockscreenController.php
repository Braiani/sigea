<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class LockscreenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lock()
    {
        Session::put('locked', true);

        return view('auth.lockscreen');
    }

    public function unlock(Request $request)
    {
        $password = $request->password;

        if (Hash::check($password, Auth::user()->password)) {
            Session::forget('locked');

            toastr()->success('Usuário desbloquado');

            return redirect()->route('sigea.dashboard');
        }

        toastr()->error('Senha incorreta');

        return redirect()->route('lockscreen');
    }
}
