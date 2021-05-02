<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pathSampleFull = base_path('vendor/s-cart/core/src/DB/sample.sql');
        $search = [
            '__SC_DB_PREFIX__',
        ];
        $replace = [
            SC_DB_PREFIX,
        ];
        $content = str_replace(
            $search,
            $replace,
            file_get_contents($pathSampleFull)
        );
        DB::connection(SC_CONNECTION)->unprepared($content);

    }
}
