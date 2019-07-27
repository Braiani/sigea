<?php

namespace App\Jobs;

use App\Models\Matricula;
use App\Traits\RetreiveSigaInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class RetrieveGradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use RetreiveSigaInfo;

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

        if (!Storage::disk('public')->directories($matricula->id . DIRECTORY_SEPARATOR . $semestre)) {
            Storage::disk('public')->makeDirectory($matricula->id . DIRECTORY_SEPARATOR . $semestre);
        }

        $file = $this->getGradeInfo($matricula->id, $semestre);

        $path = $matricula->id . DIRECTORY_SEPARATOR . $semestre . DIRECTORY_SEPARATOR . $matricula->student->name . ".pdf";

        Storage::disk('public')->put($path, $file);

        dispatch((new SendMailRematriculaDoneJob($matricula, $semestre))->onQueue('sending'));
    }
}
