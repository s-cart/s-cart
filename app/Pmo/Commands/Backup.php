<?php

namespace App\Pmo\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Throwable;

class Backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:backup {--path=} {--includeTables=} {--excludeTables=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database "sc:backup --path=abc.sql --includeTables=table1,table2 --excludeTables=t1,t2"';
    const LIMIT = 10;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = $this->option('path');
        $includeTables = $this->option('includeTables');
        $excludeTables = $this->option('excludeTables');
        if (count(glob(storage_path() . "/backups/*.sql")) >= self::LIMIT) {
            echo json_encode(['error' => 1, 'msg' => sc_language_render('admin.backup.limit_backup')]);
            exit;
        }
        if ($path) {
            $fileBackup = Str::finish(storage_path('backups/' . $path), '.sql');
        } else {
            $fileBackup = storage_path('backups/backup-' . date('Y-m-d-H-i-s') . '.sql');
        }
        try {
            $databaseName = config('database.connections.'.SC_CONNECTION.'.database');
            $userName = config('database.connections.'.SC_CONNECTION.'.username');
            $password = config('database.connections.'.SC_CONNECTION.'.password');
            $host = config('database.connections.'.SC_CONNECTION.'.host');
            $pathMysqlBin = config('database.connections.'.SC_CONNECTION.'.path_mysql_bin');// C:\xampp\mysql\bin
            $includeTables = explode(',', $includeTables);
            $excludeTables = explode(',', $excludeTables);

            $backupProcess = \Spatie\DbDumper\Databases\MySql::create()
                ->setDbName($databaseName)
                ->setUserName($userName)
                ->setPassword($password)
                ->setHost($host);
            if ($pathMysqlBin) {
                $backupProcess->setDumpBinaryPath($pathMysqlBin);
            }
            if ($includeTables) {
                $backupProcess->includeTables($includeTables);
            } elseif ($excludeTables) {
                $backupProcess->excludeTables($excludeTables);
            }
            $backupProcess->dumpToFile($fileBackup);

            echo json_encode(['error' => 0, 'msg' => 'Backup success path '.$fileBackup]);
            exit;
        } catch (Throwable $exception) {
            if (file_exists($fileBackup)) {
                @unlink($fileBackup);
            }
            sc_report($exception->getMessage());
            echo json_encode(['error' => 1, 'msg' => $exception->getMessage()]);
            exit;
        }
    }
}
