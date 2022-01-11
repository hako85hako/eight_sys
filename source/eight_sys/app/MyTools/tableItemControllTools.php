<?php
namespace App\MyTools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\attendance;
use App\Models\attendance_detail;
use App\Models\user_detail;
use App\Models\status_item;


class tableItemControllTools{

    public function DBrollback($e){
        //ロールバック処理
        DB::rollback();
        //ログ出力
        \Log::error($e);
    }

    public function create_userDetail(){
        return new user_detail();
    }

    public function create_attendance(){
        return new attendance();
    }

    public function create_attendanceDetail(){
        return new attendance_detail();
    }

    public function get_userDetail_from_userId($user_id){
        return user_detail::where('DELETE_FLG',False)
                ->where('user_id',$user_id)
                ->first();
    }

    public function get_attendance_from_date_and_userId($user_id,$date){
        return attendance::where('DELETE_FLG',False)
                ->where('user_id',$user_id)
                ->whereDate('date',$date)
                ->first();
    }

    public function get_attendance_from_id($id){
        return attendance::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }

    public function get_attendanceDetail_from_attendanceId_orderBy($attendance_id,$column_name,$asc_dsc){
        return attendance_detail::where('DELETE_FLG',False)
                ->where('attendance_id',$attendance_id)
                ->orderBy($column_name,$asc_dsc)
                ->get();
    }

    public function get_attendanceDetail_from_attendanceId($attendance_id){
        return attendance_detail::where('DELETE_FLG',False)
                ->where('attendance_id',$attendance_id)
                ->get();
    }

    public function get_attendanceDetail_from_id($id){
        return attendance_detail::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }


    public function get_statusItem_from_companyId($company_id){
        return status_item::where('DELETE_FLG',False)
                ->where('company_id',$company_id)
                ->get();
    }

    public function get_statusItem_from_id($id){
        return status_item::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }
    
}

