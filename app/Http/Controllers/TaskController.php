<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\User;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_to' => 'required',
            'task' => 'required'
        ]);

        return $request;

        if (Task::create([
            'user_to' => $request->user_to,
            'task' => $request->task,
            'deadline' => $request->deadline,
            'owner' => $request->user()->id,
        ])) {
            return [
                'error' => false,
                'message' => 'Alterações salvas com sucesso'
            ];
        }
        return [
            'error' => true,
            'message' => 'Não foi possível cadastrar a pasta!'
        ];
    }

    public function update(Request $request, Task $task)
    {
        //
    }

    public function destroy(Request $request, Task $task)
    {
        //
    }

    public function getUsers()
    {
        return User::select('id', 'name as nome')->get();
    }
}
