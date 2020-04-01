<?php
/**
 * This file load data from csv, xls, xlsx
 */
namespace App\Library\ProcessData;

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class Import
{
    public function readFile($path = '', $type = 'csv', $opt = []) {
        if(file_exists($path)) {

            if($type == 'xls') {
                $reader = new Xls;
            }
            else if($type == 'xlsx') {
                $reader = new Xlsx;
            } else {
                $reader = new Csv;
            }
            try {
                $spreadsheet = $reader->load($path);
                $spreadsheet = $spreadsheet->getActiveSheet()->toArray();
                return $spreadsheet;
            } catch (\Exception $e) {
                return ['error' => 1, 'msg' => $e->getMessage()];
            }

        } else {
            return ['error' => 1, 'msg' => 'File not exist'];
        }

    }
}
