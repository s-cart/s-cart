<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataSampleShopSeeder extends Seeder
{
    use \SCart\Core\DB\Traits\DataSampleShopSeederTrait;

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
