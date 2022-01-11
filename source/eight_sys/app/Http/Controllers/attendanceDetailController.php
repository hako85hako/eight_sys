<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\MyTools\tableItemControllTools;



/**
 * attendance_detailsに関するController
 * 
 * 
 */
class attendanceDetailController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/attendanceDetail」へのGETアクセス
    public function index(){
        
        
        return view('attendanceDetail/index');
    }

    //詳細表示
    //「/attendanceDetail/{id}」へのアクセス
    public function show(){
        
        return view('attendanceDetail/show');
    }

    /**
     * 新規作成画面への遷移
     *「/attendanceDetail/create」へのアクセス
     * 
     * 
    **/
    public function create(Request $request){
        $work_flg = 0;
        $rest_flg = 0;
        $request_rest_flg = 0;
        $attendance = "";
        //トランザクション処理
        DB::beginTransaction();
        try{
            if(isset($request->attendance_id)){
                //二回目以降の登録時
                $attendance = tableItemControllTools::get_attendance_from_id($request->attendance_id);
            }else{
                //初回登録時
                $attendance = tableItemControllTools::create_attendance();
                $attendance->user_id = Auth::user()->id;
                $attendance->date = $request->date;
            }
            $attendance->CREATE_USER = Auth::user()->name;
            $attendance->UPDATE_USER = Auth::user()->name;
            $attendance->CREATE_USER_ID = Auth::user()->id;
            $attendance->UPDATE_USER_ID = Auth::user()->id;
            $attendance->save();
        
            $attendance_detail = tableItemControllTools::create_attendanceDetail();
            $attendance_detail->attendance_id = $attendance->id;
            $attendance_detail->status = $request->status_item;
            if($request->start_time_item>$request->stop_time_item){
                throw new Exception('指定範囲エラー');
            }else{
                $attendance_detail->start_time = $request->start_time_item;
                $attendance_detail->stop_time = $request->stop_time_item;
            }
            $work_confirm = tableItemControllTools::get_statusItem_from_id($request->status_item);
            if($work_confirm->work_flg){
                $attendance_detail->work_flg = 1;
            }
            if($work_confirm->rest_flg){
                $attendance_detail->rest_flg = 1;
            }
            if($work_confirm->request_rest_flg){
                $attendance_detail->request_rest_flg = 1;
            }
            $attendance_detail->CREATE_USER = Auth::user()->name;
            $attendance_detail->UPDATE_USER = Auth::user()->name;
            $attendance_detail->CREATE_USER_ID = Auth::user()->id;
            $attendance_detail->UPDATE_USER_ID = Auth::user()->id;

            $attendance_detail->save();
            
            //attendanceのメインステータス更新処理
            //attendanceに登録されているdetailを抽出
            $all_attendance_detail = tableItemControllTools::get_attendanceDetail_from_attendanceId($attendance->id);
            foreach($all_attendance_detail as $i){
                if($i->work_flg){
                    $work_flg += 1;
                }
                if($i->rest_flg){
                    $rest_flg += 1;
                }
                if($i->request_rest_flg){
                    $request_rest_flg += 1;
                }
            }
            //メインステータス割り振り
            $attendance->main_status = $this->selectMainStatus($work_flg,$rest_flg,$request_rest_flg);
            $attendance->save();
            //コミット処理
            DB::commit();
        }catch (\Exception $e) {
            tableItemControllTools::DBrollback($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        return redirect("/attendance");
    }

    //新規作成処理
    //「/attendanceDetail」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/attendanceDetail");
    }

    //編集画面への遷移
    //「/attendanceDetail/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('attendanceDetail/edit');
    }

    //編集処理→論理削除処理
    //「/attendanceDetail/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        $work_flg = 0;
        $rest_flg = 0;
        $request_rest_flg = 0;
        //トランザクション処理
        DB::beginTransaction();
        try{
            $attendance_detail = tableItemControllTools::get_attendanceDetail_from_id($id);
            $attendance_detail->DELETE_FLG = True;
            $attendance_detail->save();
            $all_attendance_detail = tableItemControllTools::get_attendanceDetail_from_attendanceId($attendance_detail->attendance_id);
            foreach($all_attendance_detail as $one_attendance_detail){
                if($one_attendance_detail->work_flg){
                    $work_flg += 1;
                }
                if($one_attendance_detail->rest_flg){
                    $rest_flg += 1;
                }
                if($one_attendance_detail->request_rest_flg){
                    $request_rest_flg += 1;
                }
            }
            //メインステータス割り振り
            $attendance = tableItemControllTools::get_attendance_from_id($request->attendance_id);
            $attendance->main_status = $this->selectMainStatus($work_flg,$rest_flg,$request_rest_flg);
            $attendance->save();
            //コミット処理
            DB::commit();
        }catch (\Exception $e) {
            tableItemControllTools::DBrollback($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        
        return redirect("/attendance");
    }

    //削除処理
    //「/attendanceDetail/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/attendanceDetail");
    }

    /** 
     * フラグによるステータス割り振り処理
     * 
     *
     *  
    **/
    private function selectMainStatus($work_flg,$rest_flg,$request_rest_flg){
        $result = "--";
        if($work_flg>0&&$rest_flg>0&&$request_rest_flg>0){
            $result = "error";
        
        }elseif($work_flg>0&&$rest_flg>0&&$request_rest_flg==0){
            $result = "error";
              
        }elseif($work_flg>0&&$rest_flg==0&&$request_rest_flg>0){
            $result = "時間休";
            
        }elseif($work_flg>0&&$rest_flg==0&&$request_rest_flg==0){
            $result = "勤務";
           
        }elseif($work_flg==0&&$rest_flg>0&&$request_rest_flg==0){
            $result = "休暇";

        }elseif($work_flg==0&&$rest_flg==0&&$request_rest_flg>0){
            $result = "有給休暇";

        }
        return $result;
    }
}
