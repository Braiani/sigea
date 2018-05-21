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
            return redirect()
                ->route('sigea.dashboard')
                ->with([
                    'message' => 'Usuário desbloquado',
                    'alert-type' => 'success'
                ]);
        }

        return redirect()
                ->route('lockscreen')
                ->with([
                    'message' => 'Senha incorreta',
                    'alert-type' => 'error'
                ]);
    }
}
