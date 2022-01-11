<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use App\Models\status_item;
use App\Models\department_item;
use App\Models\company_requestRest_setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * 設定に関するController
 * 
 * 
 * 
 */
class settingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/setting」へのGETアクセス
    public function index(){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();

        $status_items = status_item::where('DELETE_FLG',False)
                ->where('company_id',$user_detail->company_id)
                ->get();
        
        $department_items = department_item::where('DELETE_FLG',False)
                ->where('company_id',$user_detail->company_id)
                ->get();
        
        $requestRest_settings = company_requestRest_setting::where('DELETE_FLG',False)
                ->where('company_id',$user_detail->company_id)
                ->get();
        return view('setting/index',compact('status_items','department_items','requestRest_settings'));
    }

    //詳細表示
    //「/setting/{id}」へのアクセス
    public function show(){
        
        return view('setting/show');
    }

    /**
     * 新規作成画面への遷移
     * 「/setting/create」へのアクセス
     * 
     */
    public function create(Request $request){
        //トランザクション開始
        DB::beginTransaction();
        try{
            $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
            if($request->select == 'status'){
                $status_item = new status_item();
                $status_item->company_id = $user_detail->company_id;
                
                $status_item->status_name = $request->status_name;
                if($request->work_flg == 'on'){
                    $request->work_flg = 1;
                }else{
                    $request->work_flg = 0;
                }
                if($request->rest_flg == 'on'){
                    $request->rest_flg = 1;
                }else{
                    $request->rest_flg = 0;
                }
                if($request->request_rest_flg == 'on'){
                    $request->request_rest_flg = 1;
                }else{
                    $request->request_rest_flg = 0;
                }
                $status_item->work_flg = $request->work_flg;
                $status_item->rest_flg = $request->rest_flg;
                $status_item->request_rest_flg = $request->request_rest_flg;

                $status_item->CREATE_USER = Auth::user()->name;
                $status_item->UPDATE_USER = Auth::user()->name;
                $status_item->CREATE_USER_ID = Auth::user()->id;
                $status_item->UPDATE_USER_ID = Auth::user()->id;

                $status_item->save();
                //コミット処理
                DB::commit();
            }else if($request->select == 'department'){
                $department_item = new department_item();
                $department_item->company_id = $user_detail->company_id;
                $department_item->department_name_1 = $request->department_name_1;
                $department_item->department_name_2 = $request->department_name_2;

                $department_item->CREATE_USER = Auth::user()->name;
                $department_item->UPDATE_USER = Auth::user()->name;
                $department_item->CREATE_USER_ID = Auth::user()->id;
                $department_item->UPDATE_USER_ID = Auth::user()->id;

                $department_item->save();
                //コミット処理
                DB::commit();
            }
        }catch (\Exception $e) {
            //ロールバック処理
            DB::rollback();
            //ログ出力
            \Log::error($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        
        return redirect("/setting");
    }


    //新規作成処理
    //「/setting」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/setting");
    }

    //編集画面への遷移
    //「/setting/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('setting/edit', compact(''));
    }

    /**
     * 編集処理
     * 「/setting/{id}」へのPUTアクセス
     * 
     */
    public function update(Request $request, $id){
        //トランザクション開始
        DB::beginTransaction();
        try{
            if($request->select == 'status'){
                $status_item = status_item::where('DELETE_FLG',False)
                        ->where('id',$id)
                        ->first();
                $status_item->status_name = $request->status_name;
                if($request->work_flg == 'on'){
                    $request->work_flg = 1;
                }else{
                    $request->work_flg = 0;
                }
                if($request->rest_flg == 'on'){
                    $request->rest_flg = 1;
                }else{
                    $request->rest_flg = 0;
                }
                if($request->request_rest_flg == 'on'){
                    $request->request_rest_flg = 1;
                }else{
                    $request->request_rest_flg = 0;
                }
                $status_item->work_flg = $request->work_flg;
                $status_item->rest_flg = $request->rest_flg;
                $status_item->request_rest_flg = $request->request_rest_flg;

                $status_item->UPDATE_USER = Auth::user()->name;
                $status_item->UPDATE_USER_ID = Auth::user()->id;

                $status_item->save();
                //コミット処理
                DB::commit();
            }else if($request->select == 'department'){
                $department_item = department_item::where('DELETE_FLG',False)
                        ->where('id',$id)
                        ->first();
                $department_item->department_name_1 = $request->department_name_1;
                $department_item->department_name_2 = $request->department_name_2;

                $department_item->UPDATE_USER = Auth::user()->name;
                $department_item->UPDATE_USER_ID = Auth::user()->id;
                $department_item->save();
                //コミット処理
                DB::commit();
            }        
        }catch (\Exception $e) {
            //ロールバック処理
            DB::rollback();
            //ログ出力
            \Log::error($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        
        return redirect("/setting");
    }

    //削除処理
    //「/setting/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/setting");
    }
}