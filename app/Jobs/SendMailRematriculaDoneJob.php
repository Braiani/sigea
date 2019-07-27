<?php

namespace App\Jobs;

use App\Models\Matricula;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendMailRematriculaDoneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $matricula, $semestre;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Matricula $matricula, $semestre)
    {
        $this->matricula = $matricula;
        $this->semestre = $semestre;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $matricula = $this->matricula->load('student');
        $semestre = $this->semestre;
        $token = sha1('IFMS' . $matricula->id);
        $urlSiga = "https://academico.ifms.edu.br/administrativo/matriculas/comprovante_matricula_publico/{$matricula->id}/{$semestre}?token={$token}";
        $path = $matricula->id . DIRECTORY_SEPARATOR . $semestre . DIRECTORY_SEPARATOR . $matricula->student->name . ".pdf";

        Mail::send('emails.rematricula-finished', compact('urlSiga', 'matricula'), function ($message) use ($matricula, $semestre, $path) {
            $message->from('cogea.cg@ifms.edu.br', 'Coordenação de Gestão Acadêmica - CG');
            $message->replyTo('cogea.cg@ifms.edu.br');
            $message->to($matricula->student->email);
            $message->subject('Informações: Rematrícula ' . $semestre . ' - Campus Campo Grande');
            $message->attach(public_path() . Storage::url($path));
        });
    }
}
