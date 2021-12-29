<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\attendance;
use App\Models\attendance_detail;
use App\Models\status_item;
use Exception;

class attendanceDetailController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/attendanceDetail」へのGETアクセス
    public function index(){
        
        
        return view('attendanceDetail/index', compact(''));
    }

    //詳細表示
    //「/attendanceDetail/{id}」へのアクセス
    public function show(){
        
        return view('attendanceDetail/show', compact(''));
    }

    //新規作成画面への遷移
    //「/attendanceDetail/create」へのアクセス
    public function create(Request $request){
        $work_flg = 0;
        DB::beginTransaction();
        try{
            if(isset($request->attendance_id)){
                //初回登録時
                $attendance = attendance::where('DELETE_FLG',False)
                ->where('id',$request->attendance_id)
                ->first();
            }else{
                //二回目以降の登録時
                $attendance = new attendance();
                $attendance->user_id = Auth::user()->id;
                $attendance->date = $request->date;
            }
            $attendance->CREATE_USER = Auth::user()->name;
            $attendance->UPDATE_USER = Auth::user()->name;
            $attendance->CREATE_USER_ID = Auth::user()->id;
            $attendance->UPDATE_USER_ID = Auth::user()->id;
            $attendance->save();
        
            $attendance_detail = new attendance_detail();
            $attendance_detail->attendance_id = $attendance->id;
            $attendance_detail->status = $request->status_item;
            if($request->start_time_item>$request->stop_time_item){
                throw new Exception('指定範囲エラー');
            }else{
                $attendance_detail->start_time = $request->start_time_item;
                $attendance_detail->stop_time = $request->stop_time_item;
            }
            $work_confirm = status_item::where('DELETE_FLG',False)
            ->where('id',$request->status_item)
            ->first();
            if($work_confirm->work_flg){
                $attendance_detail->work_flg = 1;
            }
            $attendance_detail->CREATE_USER = Auth::user()->name;
            $attendance_detail->UPDATE_USER = Auth::user()->name;
            $attendance_detail->CREATE_USER_ID = Auth::user()->id;
            $attendance_detail->UPDATE_USER_ID = Auth::user()->id;

            $attendance_detail->save();
            
            //attendanceのメインステータス更新処理
            //attendanceに登録されているdetailを抽出
            $all_attendance_detail = attendance_detail::where('DELETE_FLG',False)
            ->where('attendance_id',$attendance->id)
            ->get();
            for($i = 0; $i<count($all_attendance_detail);$i++){
                if($all_attendance_detail[$i]->work_flg){
                    $work_flg += 1;
                }
            }
            if($work_flg>0){
                    $attendance->main_status = "労働";
                    $attendance->save();
            }else{
                    $attendance->main_status = "--";
                    $attendance->save();
            }
            DB::commit();
        }catch (Exception $e) {
            DB::rollback();
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
        
        return view('attendanceDetail/edit', compact(''));
    }

    //編集処理
    //「/attendanceDetail/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        $attendance_detail = attendance_detail::where('DELETE_FLG',False)
        ->where('id',$id)
        ->first();
        $attendance_detail->DELETE_FLG = True;
        $attendance_detail->save();
        return redirect("/attendance");
    }

    //削除処理
    //「/attendanceDetail/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/attendanceDetail");
    }
}
