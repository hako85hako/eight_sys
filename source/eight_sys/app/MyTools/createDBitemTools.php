<?php
namespace App\MyTools;

use App\Models\user_detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class createDBitemTools{

    public function DBrollback(){
        //ロールバック処理
        DB::rollback();
        //ログ出力
        \Log::error($e);
    }


    public function createUserDetail(){
        return user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
    }
}

