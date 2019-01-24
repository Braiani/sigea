<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Candidato;
use Illuminate\Support\Facades\Mail;

class SendEmailMatricula implements ShouldQueue
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
        if ($candidato->cotaIngresso->analise_renda) {
            Mail::send('matriculas.mails.analise', ['candidato' => $candidato], function ($message) use ($candidato) {
                $message->from('cogea.cg@ifms.edu.br', 'Coordenação de Gestão Acadêmica - CG');
                $message->to($candidato->email);
                $message->subject('Informações: Matrícula no ' . $candidato->curso->nome . ' - Campus Campo Grande');
            });
        } else {
            Mail::send('matriculas.mails.matriculado', ['candidato' => $candidato], function ($message) use ($candidato) {
                $message->from('cogea.cg@ifms.edu.br', 'Coordenação de Gestão Acadêmica - CG');
                $message->to($candidato->email);
                $message->subject('Informações: Matrícula no ' . $candidato->curso->nome . ' - Campus Campo Grande');
                $message->attach(public_path() . '/storage/files/guia.pdf', [
                    'as' => 'Guia de Boas-vindas IFMS.pdf'
                ]);
            });
        }
    }
}
