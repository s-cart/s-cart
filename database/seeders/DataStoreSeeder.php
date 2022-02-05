<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataStoreSeeder extends Seeder
{
    use \SCart\Core\DB\Trait\DataStoreSeederTrait;
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
