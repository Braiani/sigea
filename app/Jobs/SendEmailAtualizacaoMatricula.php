<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Candidato;

class SendEmailAtualizacaoMatricula implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $candidato;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato)
    {
        $this->candidato = $candidato;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $candidato = $this->candidato;
        Mail::send('matriculas.mails.atualizacao', ['candidato' => $candidato], function ($message) use ($candidato) {
            $message->from('cogea.cg@ifms.edu.br', 'Coordenação de Gestão Acadêmica - CG');
            $message->to($candidato->email);
            $message->subject('Atualização: Matrícula no ' . $candidato->curso->nome . ' - Campus Campo Grande');
        });
    }
}
