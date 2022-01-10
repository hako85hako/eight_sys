<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usersTableSeeder extends Seeder
{
    public function run()
    {
        // テーブルのクリア
        DB::table('users')->truncate();

        // company初期データ用意（列名をキーとする連想配列）
        $users = [
                [   
                    'name' => 'test',
                    'email' => 'test@test',
                    'password' => '$2y$10$cQPflKHg3qikS7dauzCUkef7NvQ8H0pgNg4z.4EDy0ZrxJeGuOZim',
                ]
            ];
        // 登録
        foreach($users as $user){
            \App\Models\User::create($user);
        }
    }
    
}