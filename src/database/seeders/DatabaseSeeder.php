<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Stamp;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Stamp::factory()->count(100)->create();
    }
}
