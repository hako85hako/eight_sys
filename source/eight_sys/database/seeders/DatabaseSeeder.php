<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // companysTableSeederを読み込むように指定
        $this->call(companysTableSeeder::class);
    }
}
