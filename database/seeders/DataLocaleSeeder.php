<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataLocaleSeeder extends Seeder
{
    use \SCart\Core\DB\Traits\DataLocaleSeederTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return $this->runProcess();
    }
}
