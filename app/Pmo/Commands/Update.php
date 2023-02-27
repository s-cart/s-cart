<?php

namespace App\Pmo\Commands;

use Illuminate\Console\Command;
use Throwable;
use DB;
use Illuminate\Support\Facades\Artisan;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update s-pmo core"';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            Artisan::call('db:seed', 
                [
                    '--class' => 'DataDefaultSeeder',
                    '--force' => true
                ]
            );
            Artisan::call('db:seed', 
                [
                    '--class' => 'DataLocaleSeeder',
                    '--force' => true
                ]
            );
            $this->info('Update done');
        } catch (Throwable $e) {
            sc_report($e->getMessage());
            echo  json_encode(['error' => 1, 'msg' => $e->getMessage()]);
            exit();
        }
    }
}
