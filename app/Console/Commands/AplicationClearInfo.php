<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AplicationClearInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'braiani:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple command to clear cache, view, route and config!';

    protected $commands = ['cache:clear', 'view:clear', 'route:clear', 'config:clear'];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->commands as $command) {
            $this->call($command);
        }
    }
}
