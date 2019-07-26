<?php

namespace App\Jobs;

use App\Models\Matricula;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SendMailRematriculaDoneJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $matricula;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Matricula $matricula)
    {
        $this->matricula = $matricula;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(10);
        Log::info('Sending mail....: ' . $this->matricula);
    }
}
