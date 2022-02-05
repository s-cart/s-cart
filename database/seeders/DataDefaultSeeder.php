<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
class DataDefaultSeeder extends Seeder
{
    use \SCart\Core\DB\Trait\DataDefaultSeederTrait;

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
