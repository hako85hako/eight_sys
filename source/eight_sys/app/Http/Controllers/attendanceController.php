<?php

namespace App\Http\Controllers;

use App\MyTools\dateControllTools;

use App\Models\attendance;
use App\Models\attendance_detail;
use App\Models\status_item;
use App\Models\user_detail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * 勤怠に関するController
 * 
 * 
 */
class attendanceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     *「/attendance」へのGETアクセス
     *　勤怠画面への遷移
     * 
     *
    **/
    public function index(Request $request){
        $date_now = date("Y-m-d", strtotime(date('Y-m-d')."-2 month"));
        $myTools = new dateControllTools();
        $user_detail = createDBitemTools::createUserDetail();
        //初回アクセスの場合
        if(!isset($user_detail->user_id)){
            //月情報付与
            $month_inf = date('Y-m');
            //トランザクション開始
            DB::beginTransaction();
            try{
                //新規user_detail登録
                $user_detail = new user_detail();
                $user_detail->user_id = Auth::user()->id;
                $user_detail->date_inf = date('Y-m-d');
                $user_detail->company_id = '1';//TODO 要修正
                $user_detail->name = Auth::user()->name;
                $user_detail->role = "user";//TODO 要修正
                $user_detail->department_id = '1';//初期設定
                $user_detail->CREATE_USER = Auth::user()->name;
                $user_detail->UPDATE_USER = Auth::user()->name;
                $user_detail->CREATE_USER_ID = Auth::user()->id;
                $user_detail->UPDATE_USER_ID = Auth::user()->id;
                $user_detail->save();
                //コミット処理
                DB::commit();
            }catch (\Exception $e) {
                createDBitemTools::DBrollback();
                print($e->getMessage());
                print('DBcommit失敗');
            }
        }else{
            DB::beginTransaction();
            try{
                //選択月情報の設定
                if(isset($request->select_month)){
                    if($request->move_month == 'next'){
                        $month_inf = date("Y-m", strtotime($request->select_month." 1 month"));
                    }else if($request->move_month == 'back'){
                        $month_inf = date("Y-m", strtotime($request->select_month." -1 month"));
                    }else{
                        $month_inf = date('Y-m',strtotime($request->select_month));
                    }
                }else{
                    $month_inf = date('Y-m',strtotime($user_detail->date_inf));
                }
                $user_detail->date_inf = $month_inf.'-01';
                $user_detail->save();
                //コミット処理
                DB::commit();
            }catch (\Exception $e) {
                createDBitemTools::DBrollback();
                print($e->getMessage());
                print('DBcommit失敗');
            }
        }

        //トランザクション開始
        DB::beginTransaction();
        try{
            //指定月の日数分のアイテムを作成
            $date_items = array();
            $monitor_date = $user_detail->date_inf;
            //月の日数を取得
            if(!isset($monitor_date)){
                $monitor_date = date('Y-m-d');
            }

            for($i=1; $i<(date("t", strtotime($monitor_date)))+1;$i++){
                $select_month = date("Y-m", strtotime($monitor_date));
                //Y-m-dの形に変換
                $dateBuff = $select_month.'-'.$i;
                $dateBuff = date("Y-m-d", strtotime($dateBuff));
                //m月d日の形に変換
                $preDate = date("m月d日", strtotime($dateBuff));
                //曜日を数字で取得
                $preDayOfWeek = date("N", strtotime($dateBuff));
                //日本語の曜日を取得
                $dayOfWeek = dateControllTools::get_dayOfWeek($preDayOfWeek);
                
                //attendanceを取得
                $attendance = attendance::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->whereDate('date',$dateBuff)
                ->first();
                if(isset($attendance->id)){
                    //print('attendanceあり');
                    $main_status = $attendance->main_status;
                    $update_date = $attendance->UPDATED_AT;
                    $attendance_details = attendance_detail::where('DELETE_FLG',False)
                    ->where('attendance_id',$attendance->id)
                    ->orderBy('start_time','ASC')
                    ->get();
                    $total_time = '00:00';
                    $total_hours = 0;
                    $total_minutes = 0;
                    foreach($attendance_details as $attendance_detail){
                        $start_time = date_create($attendance_detail->start_time);
                        $stop_time = date_create($attendance_detail->stop_time);
                        $date_diff = date_diff($start_time,$stop_time);
                        if($attendance_detail->work_flg){
                            $total_hours += $date_diff->h;
                            $total_minutes += $date_diff->i;
                        }
                    }
                    $minutes = $total_minutes%60;
                    $hour = $total_hours + (($total_minutes-$minutes)/60);
                    if($minutes<10){
                        $minutes = '0'.$minutes;
                    }
                    if($hour<10){
                        $hour = '0'.$hour;
                    }
                    $total_time = $hour.":".$minutes;
                    $attendance_id = $attendance->id;
                }else{ 
                    //print('attendanceなし');
                    $attendance_id = '-';
                    $main_status = '--';
                    $update_date = '--:--';
                    $total_time = '--:--';
                    $attendance_details = "";
                }
                $date_items[] = [
                    $preDate."(".$dayOfWeek.")",
                    $dateBuff,
                    $main_status,
                    $total_time,
                    $update_date,
                    $attendance_id,
                    $attendance_details,
                    $date_now
                ];
            }
            //企業別勤怠状態の作成
            $status_items = status_item::where('DELETE_FLG',False)
            ->where('company_id',$user_detail->company_id)
            ->get();
            //時間情報の作成
            $time_items =  array();
            $t = strtotime('00:00');
            for ($i = 0; $i < 5 * 12 * 24; $i += 15) {
                $time_items[] = date('H:i', strtotime("+{$i} minutes", $t)) . PHP_EOL;
            }
            //コミット処理
            DB::commit();
        }catch (\Exception $e) {
            createDBitemTools::DBrollback();
            print($e->getMessage());
            print('DBcommit失敗');
        }
        //date_itemの中身メモ
        //[0]：m月d日(N)
        //[1]：Y-m-d
        //これ以下はDB操作必要
        //[2]：main_status
        //[3]：total_time
        //[4]：update_datetime
        //[5]：attendance_id
        //[6]：attendance_details → object
        //[7]：date_now;
        return view('attendance/index',compact('user_detail','date_items','status_items','time_items','month_inf'));
    }

    //詳細表示
    //「/attendance/{id}」へのアクセス
    public function show(){
        
        return view('attendance/show', compact(''));
    }

    //新規作成画面への遷移
    //「/attendance/create」へのアクセス
    public function create(){
        
        return view('attendance/create', compact(''));
    }

    //新規作成処理
    //「/attendance」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/attendance");
    }

    //編集画面への遷移
    //「/attendance/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('attendance/edit', compact(''));
    }

    //編集処理
    //「/attendance/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/attendance");
    }

    //削除処理
    //「/attendance/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/attendance");
    }
}
