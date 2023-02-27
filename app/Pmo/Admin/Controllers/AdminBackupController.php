<?php
namespace App\Pmo\Admin\Controllers;

use App\Pmo\Admin\Controllers\RootAdminController;
use Illuminate\Support\Facades\Artisan;
use DB;

class AdminBackupController extends RootAdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        $tableInfo = DB::connection(SC_CONNECTION)
            ->table('INFORMATION_SCHEMA.TABLES')
            ->select(['table_name', 'table_rows', 'data_length'])
            ->where('TABLE_SCHEMA', config('database.connections.'.SC_CONNECTION.'.database'))
            ->where('table_type', 'BASE TABLE')
            ->get()
            ->toArray();

        $listFiles = glob(storage_path() . "/backups/*.sql");
        $download = request('download') ?? '';
        if ($download) {
            $file = storage_path() . "/backups/" . $download;
            if (file_exists($file) && in_array($file, $listFiles)) {
                $headers = array(
                    'Content-Type' => 'application/octet-stream',
                );
                return response()->download($file, '', $headers);
            }
        }
        $arrFiles = [];
        foreach ($listFiles as $file) {
            if (file_exists($file)) {
                $fileInfo         = [];
                $fileInfo['path'] = $file;
                $arr              = explode('/', $file);
                $fileInfo['name'] = end($arr);
                $fileInfo['size'] = number_format(filesize($file) / 1048576, 3) . 'MB';
                $fileInfo['time'] = date('Y-m-d H:i:s', filemtime($file));
                $arrFiles[date('Y-m-d H:i:s', filemtime($file))]       = $fileInfo;
            }
        }
        krsort($arrFiles);
        return view($this->templatePathAdmin.'screen.backup')->with(
            [
                "title"    => sc_language_render('admin.backup.title'),
                "arrFiles" => $arrFiles,
                "tableInfo" => $tableInfo,
            ]
        )->render();
    }

    /**
     * Process file backup
     *
     * @return  [type]  [return description]
     */
    public function processBackupFile()
    {
        $file     = request('file');
        $action   = request('action');
        $pathFull = storage_path() . "/backups/" . $file;
        $return   = ['error' => '', 'msg' => ''];
        if ($action === 'remove') {
            try {
                unlink($pathFull);
                $return = ['error' => 0, 'msg' => sc_language_render('action.remove_success')];
            } catch (\Throwable $e) {
                $return = ['error' => 1, 'msg' => $e->getMessage()];
            }
        } elseif ($action === 'restore') {
            try {
                $return = Artisan::call("sc:restore --path=".$file);
            } catch (\Throwable $e) {
                sc_report($e->getMessage());
                $return = json_encode(['error' => 1, 'msg' => $e->getMessage()]);
            }
        }

        return $return;
    }

    /**
     * Create file backup
     *
     * @return  [type]  [return description]
     */
    public function generateBackup()
    {
        $data = request()->all();
        $fileName = $data['fileName'] ?? '';
        $includeTables = $data['includeTables'] ?? '';
        $excludeTables = $data['excludeTables'] ?? '';
        $return = Artisan::call("sc:backup --path=$fileName --includeTables=$includeTables --excludeTables=$excludeTables");
        return $return;
    }
}
