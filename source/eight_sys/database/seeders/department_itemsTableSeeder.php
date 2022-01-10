<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class department_itemsTableSeeder extends Seeder
{
    public function run()
    {
        // テーブルのクリア
        DB::table('department_items')->truncate();

        // company初期データ用意（列名をキーとする連想配列）
        $department_items = [
                [   
                    'company_id' => '1',
                    'department_name_1' => '初期',
                    'department_name_2' => '設定',
                    'UPDATE_USER' => 'admin',
                    'CREATE_USER' => 'admin',
                    'UPDATE_USER_ID' => '0',
                    'CREATE_USER_ID' => '0',
                ]
            ];
        // 登録
        foreach($department_items as $department_item){
            \App\Models\User::create($department_item);
        }
    }
    
}