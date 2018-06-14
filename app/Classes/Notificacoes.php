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
        return [
            'total' => $this->total,
            'not_cont' => $this->retorno
        ];
    }
}
