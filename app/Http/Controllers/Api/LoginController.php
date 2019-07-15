<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\Student;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __invoke(ApiLoginRequest $request)
    {
//        sleep(2);

        try {
            $student = Student::where('cpf', $request->cpf)->where('born', $request->nascimento)
                ->with(['matriculas', 'matriculas.course'])->firstOrFail();

            $student->update([
                'api_token' => Str::random(50)
            ]);

            return $student;
        } catch (\Exception $exception) {
            $resposta = [
                'error' => true,
                'message' => "Estudante não encontrado"
            ];
            return response($resposta);
        }
    }
}
