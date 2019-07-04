<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RematriculaController extends Controller
{
    public function getQse(Request $request, $cpf)
    {
        return rand(0,1);
    }
}
