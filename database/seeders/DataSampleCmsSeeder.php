<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataSampleCmsSeeder extends Seeder
{
    use \SCart\Core\DB\Traits\DataSampleCmsSeederTrait;

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
