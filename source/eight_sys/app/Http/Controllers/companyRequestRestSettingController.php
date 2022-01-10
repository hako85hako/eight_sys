<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user_detail;
use App\Models\company_requestRest_setting;
use Illuminate\Support\Facades\Auth;


/**
 * 企業の有給休暇設定に関するController
 * 
 */
class companyRequestRestSettingController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    /**
     * ⭐️　使用
     *  編集処理
     * 
     * 「/companyRequestRestSetting/{id}」へのPUTアクセス
     * 
     */
    //
    //「/companyRequestRestSetting/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
        $requestRest_setting = company_requestRest_setting::where('DELETE_FLG',False)
                ->where('id',$id)
                ->first();
        
        $requestRest_setting->pass_date = $request->pass_date;
        $requestRest_setting->give_date = $request->give_date;
        if($request->active_flg=='on'){
            $requestRest_setting->active_flg = True;
        }else{
            $requestRest_setting->active_flg = False;
        }

        $requestRest_setting->UPDATE_USER = Auth::user()->name;
        $requestRest_setting->UPDATE_USER_ID = Auth::user()->id;
        $requestRest_setting->save();
        
        return redirect("/setting");
    }

    /**
     * ⭐️　使用
     *  新規作成処理
     * 
     * 「/companyRequestRestSetting」へのPOSTアクセス
     * 
     */
    public function create(Request $request){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        $requestRest_setting = new company_requestRest_setting();
        $requestRest_setting->pass_date = $request->pass_date;
        $requestRest_setting->give_date = $request->give_date;
        $requestRest_setting->company_id = $user_detail->company_id;

        $requestRest_setting->CREATE_USER = Auth::user()->name;
        $requestRest_setting->UPDATE_USER = Auth::user()->name;
        $requestRest_setting->CREATE_USER_ID = Auth::user()->id;
        $requestRest_setting->UPDATE_USER_ID = Auth::user()->id;
        $requestRest_setting->save();

        return redirect("/setting");
    }

    /**
     * ⭐️　使用
     * 削除処理
     * 「/companyRequestRestSetting/{id}」へのDELETEアクセス
     * 
     */
    public function destroy($id){
        
        return redirect("/companyRequestRestSetting");
    }


    //初期アクセス
    //「/companyRequestRestSetting」へのGETアクセス
    public function index(){
        
        return view('companyRequestRestSetting/index', compact(''));
    }

    //詳細表示
    //「/companyRequestRestSetting/{id}」へのアクセス
    public function show(){
        
        return view('companyRequestRestSetting/show', compact(''));
    }

    //新規作成画面への遷移
    //「/companyRequestRestSetting/create」へのアクセス
    public function store(){
        
        return view('companyRequestRestSetting/create', compact(''));
    }

    //編集画面への遷移
    //「/companyRequestRestSetting/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('companyRequestRestSetting/edit', compact(''));
    }

    
}
