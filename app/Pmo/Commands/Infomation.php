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
    protected $description = 'Get infomation S-Cart';
    const LIMIT = 10;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(config('s-cart.name').' - '.config('s-cart.title'));
        $this->info(config('s-cart.auth').' <'.config('s-cart.email').'>');
        $this->info('Version: '.config('s-cart.version'));
        $this->info('Sub-version: '.config('s-cart.sub-version'));
        $this->info('Core: '.config('s-cart.core'));
        $this->info('Core sub-version: '.config('s-cart.core-sub-version'));
        $this->info('Type: '.config('s-cart.type'));
        $this->info('Homepage: '.config('s-cart.homepage'));
        $this->info('Github: '.config('s-cart.github'));
        $this->info('Facebook: '.config('s-cart.facebook'));
        $this->info('API: '.config('s-cart.api_link'));
    }
}
