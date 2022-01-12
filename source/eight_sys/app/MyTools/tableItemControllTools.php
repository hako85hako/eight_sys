<?php
namespace App\MyTools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\attendance;
use App\Models\attendance_detail;
use App\Models\company;
use App\Models\company_requestRest_setting;
use App\Models\department_item;
use App\Models\User;
use App\Models\user_detail;
use App\Models\user_requestRest_log;
use App\Models\status_item;


class tableItemControllTools{

    public function DBrollback($e){
        //ロールバック処理
        DB::rollback();
        //ログ出力
        \Log::error($e);
    }


    public function create_user(){
        return new User();
    }

    public function create_userDetail(){
        return new user_detail();
    }

    public function create_attendance(){
        return new attendance();
    }

    public function create_statusItem(){
        return new status_item();
    }

    public function create_departmentItem(){
        return new department_item();
    }

    public function create_attendanceDetail(){
        return new attendance_detail();
    }

    public function create_userRequestRestLog(){
        return new user_requestRest_log();
    }

    
    //User
    public function get_user_from_id($id){
        return User::where('id',$id)
                ->first();
    }


    //user_detail
    public function get_userDetail_from_id($id){
        return user_detail::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }

    public function get_userDetail_from_userId($user_id){
        return user_detail::where('DELETE_FLG',False)
                ->where('user_id',$user_id)
                ->first();
    }

    public function get_userDetails_from_companyId($company_id){
        return user_detail::where('DELETE_FLG',False)
                ->where('company_id',$company_id)
                ->get();
    }

    //company
    public function get_company_from_id($id){
        return company::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }

    //attendance
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

    //attendance_detail
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

    //status_item
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

    //department_item
    public function get_departmentItem_from_id($id){
        return department_item::where('DELETE_FLG',False)
                    ->where('id',$id)
                    ->first();
    }


    public function get_departmentItem_from_companyId($company_id){
        return department_item::where('DELETE_FLG',False)
                    ->where('company_id',$company_id)
                    ->get();
    }

    //company_requestRest_setting
    public function get_companyRequestRestSetting_from_companyId($company_id){
        return company_requestRest_setting::where('DELETE_FLG',False)
                    ->where('active_flg',True)
                    ->where('company_id',$company_id)
                    ->get();
    }

    public function get_companyRequestRestSetting_from_beforeRequestRestId($before_requestRest_id){
        return company_requestRest_setting::where('DELETE_FLG',False)
                    ->where('active_flg',True)
                    ->where('id',$before_requestRest_id)
                    ->first();
    }

    public function get_companyRequestRestSetting_from_companyId_minimunSelect($company_id,$mini_select){
        return company_requestRest_setting::where('DELETE_FLG',False)
                    ->where('active_flg',True)
                    ->where('company_id',$company_id)
                    ->min($mini_select);
    }

    public function get_companyRequestRestSetting_from_companyId_add_one_Select($company_id,$select,$select_value){
        return company_requestRest_setting::where('DELETE_FLG',False)
                ->where('active_flg',True)
                ->where('company_id',$company_id)
                ->where($select, $select_value )
                ->first();
    }

    public function get_companyRequestRestSetting_from_companyId_and_overPassDate_minimum(
        $company_id,
        $big_or_small,
        $pass_date,
        $min_select
        ){
        return company_requestRest_setting::where('DELETE_FLG',False)
                ->where('active_flg',True)
                ->where('company_id',$company_id)
                ->where('pass_date',$big_or_small,$pass_date)
                ->min($min_select);
    }

    //user_requestRest_log
    public function get_companyRequestRestSetting_max($max_select){
        return user_requestRest_log::where('DELETE_FLG',False)
                ->max($max_select);
    }

    public function get_companyRequestRestSetting_id($id){
        return user_requestRest_log::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
    }



    
    

    
    
}