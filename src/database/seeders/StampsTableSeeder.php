<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stamp::factory()->count(100)->create();
    }
}
