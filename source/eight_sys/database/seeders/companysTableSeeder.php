<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class companysTableSeeder extends Seeder
{
    public function run()
    {
        // テーブルのクリア
        DB::table('companys')->truncate();

        // company初期データ用意（列名をキーとする連想配列）
        $companys = [
            ['name' => 'EIGHTIST',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999'], 
            ['name' => '国立循環器病研究センター',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999'], 
            ['name' => 'FieldLogic',
                'CREATE_USER' => 'test',
                'UPDATE_USER' => 'test',
                'CREATE_USER_ID' => '999',
                'UPDATE_USER_ID' => '999']
        ];
        // 登録
        foreach($companys as $company){
            \App\Models\company::create($company);
        }
    }
    
}