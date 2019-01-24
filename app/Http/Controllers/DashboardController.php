<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passivo;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('lock');
    }
    public function index()
    {
        $passivo = new Passivo;
        return view('dashboard')->with([
            'passivo' => $passivo,
        ]);
    }
}
