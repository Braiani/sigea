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

        $request->merge(['owner' => $request->user()->id]);

        if (Task::create($request->all())) {
            return [
                'error' => false,
                'message' => 'Tarefa registrada com sucesso!'
            ];
        }
        return [
            'error' => true,
            'message' => 'Não foi possível registrar  tarefa!'
        ];
    }

    public function update(Request $request, Task $task)
    {
        try{
            $this->authorize('update', $task);
        }catch(\Exception $e){
            toastr()->error('Você não tem permissão para essa ação!');
            return redirect()->route('sigea.dashboard');
        }

        if ($task->completed) {
            $task->completed = false;
            $return_msg = 'Tarefa desmarcada como concluída!';
        }else{
            $task->completed = true;
            $return_msg = 'Tarefa marcada como concluída!';
        }

        $task->save();
        toastr()->success($return_msg);
        return redirect()->route('sigea.dashboard');

    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        toastr()->success('Tarefa arquivada com sucesso!');

        return redirect()->route('sigea.dashboard');
    }

    public function getUsers(Request $request)
    {
        if ($request->user()->isAdmin) {
            return User::select('id', 'name as nome')->get();
        }
        return User::select('id', 'name as nome')->whereNotIn('role_id', [1,2])->get();
    }
}
