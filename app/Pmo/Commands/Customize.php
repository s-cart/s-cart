<?php

namespace App\Pmo\Commands;

use Illuminate\Console\Command;
use Throwable;
use DB;

class Customize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:customize {obj?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customize obj';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $obj = $this->argument('obj');
        switch ($obj) {
            case 'admin':
                $this->call('vendor:publish', ['--tag' => 'sc:config-admin']);
                $this->call('vendor:publish', ['--tag' => 'sc:view-admin']);
                break;
            
            case 'validation':
                $this->call('vendor:publish', ['--tag' => 'sc:config-validation']);
                break;

            case 'middleware':
                $this->call('vendor:publish', ['--tag' => 'sc:config-middleware']);
                break;
                
            case 'lfm':
                $this->call('vendor:publish', ['--tag' => 'sc:config-lfm']);
                break;

            case 'cart':
                $this->call('vendor:publish', ['--tag' => 'sc:config-cart']);
                break;

            case 'api':
                $this->call('vendor:publish', ['--tag' => 'sc:config-api']);
                break;

            default:
                $this->info('Nothing');
                break;
        }
    }
}
