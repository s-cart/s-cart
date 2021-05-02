<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataLocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pathLocaleFull = base_path('vendor/s-cart/core/src/DB/locale.sql');
        $search = [
            '__SC_DB_PREFIX__',
        ];
        $replace = [
            SC_DB_PREFIX,
        ];
        $content = str_replace(
            $search,
            $replace,
            file_get_contents($pathLocaleFull)
        );
        DB::connection(SC_CONNECTION)->unprepared($content);
    }
}
