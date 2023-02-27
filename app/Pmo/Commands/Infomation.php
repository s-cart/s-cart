<?php

namespace App\Pmo\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Throwable;

class Infomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get infomation s-pmo';
    const LIMIT = 10;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(config('s-pmo.name').' - '.config('s-pmo.title'));
        $this->info(config('s-pmo.auth').' <'.config('s-pmo.email').'>');
        $this->info('Version: '.config('s-pmo.version'));
        $this->info('Sub-version: '.config('s-pmo.sub-version'));
        $this->info('Core: '.config('s-pmo.core'));
        $this->info('Core sub-version: '.config('s-pmo.core-sub-version'));
        $this->info('Type: '.config('s-pmo.type'));
        $this->info('Homepage: '.config('s-pmo.homepage'));
        $this->info('Github: '.config('s-pmo.github'));
        $this->info('Facebook: '.config('s-pmo.facebook'));
        $this->info('API: '.config('s-pmo.api_link'));
    }
}
