<?php
namespace App\Classes;

use App\Mensagem;
use App\Task;

class Notificacoes
{
    private $retorno;
    private $total;
    public function __construct()
    {
        $this->retorno = [];
        $this->total = 0;
    }

    public function handle($id)
    {
        $this->mensagens($id);
        $this->tasks($id);

        return [
            'total' => $this->total,
            'not_cont' => $this->retorno
        ];
    }

    public function mensagens($id)
    {
        $mensagem = Mensagem::mailTo($id)->get()->filter(function ($value, $key){
            return $value->read == NULL or $value->read == 0;
        })->count();
        if ($mensagem > 0) {
            array_push($this->retorno, [
                'link' => 'sigea.mensagens.index',
                'mensagem' => "Você possui {$mensagem} mensagens não lidas!"
            ]);
            $this->total += $mensagem;
        }
    }

    public function tasks($id)
    {
        $tasks = Task::toUser($id)->get()->filter(function ($value, $key){
            return $value->completed == NULL or $value->completed == 0;
        })->count();
        if ($tasks > 0) {
            array_push($this->retorno, [
                'link' => 'sigea.dashboard',
                'mensagem' => "Você possui {$tasks} tarefas não concluídas!"
            ]);
            $this->total += $tasks;
        }
    }
}
