<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataSampleSeeder extends Seeder
{
    use \SCart\Core\DB\Trait\DataSampleSeederTrait;

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
