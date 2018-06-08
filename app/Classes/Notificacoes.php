<?php
namespace App\Classes;

use App\Mensagem;

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
        if (Mensagem::mailTo($id)->where('read', 0)->count() > 0) {
            array_push($this->retorno, [
            'link' => 'sigea.mensagens.index',
            'mensagem' => 'Você possui mensagens não lidas!'
        ]);
            $this->total++;
        }
        return [
            'total' => $this->total,
            'not_cont' => $this->retorno
        ];
    }
}
