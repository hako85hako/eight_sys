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
         //各種Seederを読み込むように指定
        $this->call(companysTableSeeder::class);
        $this->call(usersTableSeeder::class);
        $this->call(department_itemsTableSeeder::class);
    }
}
