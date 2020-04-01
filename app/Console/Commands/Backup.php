<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'BackupDatabase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database';
    protected $process;
    protected $fileBackup;
    const LIMIT = 10;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileBackup = storage_path('backups/backup-' . date('Y-m-d-H-i-s') . '.sql');
        $this->process    = new Process(sprintf(
            'mysqldump --user="%s" --password="%s" %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $this->fileBackup
        ));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count(glob(storage_path() . "/backups/*.sql")) >= self::LIMIT) {
            echo json_encode(['error' => 1, 'msg' => trans('backup.limit_backup')]);
            exit;
        }
        try {
            $this->process->mustRun();
            echo json_encode(['error' => 0, 'msg' => 'Backup success!']);
        } catch (\Exception $exception) {
            if (file_exists($this->fileBackup)) {
                unlink($this->fileBackup);
            }
            echo json_encode(['error' => 1, 'msg' => $exception->getMessage()]);
        }
    }
}
