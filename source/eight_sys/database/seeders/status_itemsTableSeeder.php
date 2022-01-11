<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class status_itemsTableSeeder extends Seeder
{
    public function run()
    {
        // テーブルのクリア
        DB::table('status_items')->truncate();

        // company初期データ用意（列名をキーとする連想配列）
        $status_items = [
            [   'company_id' => '1',
                'status_name' => 'work',
                'work_flg' => '1',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999'], 
            [   'company_id' => '1',
                'status_name' => 'rest',
                'rest_flg' => '1',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999'], 
            [   'company_id' => '1',
                'status_name' => 'requestRest',
                'request_rest_flg' => '1',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999']
        ];
        // 登録
        foreach($status_items as $status_item){
            \App\Models\status_item::create($status_item);
        }
    }
    
}