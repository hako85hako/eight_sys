<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use App\Models\department_item;
use Illuminate\Support\Facades\Auth;

class userDetailController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/userDetail」へのGETアクセス
    public function index(){
        $user_detail = user_detail::where('DELETE_FLG',False)
        ->where('user_id',Auth::user()->id)
        ->first();
        
        $users = user_detail::where('DELETE_FLG',False)
        ->where('company_id',$user_detail->company_id)
        ->get();

        $department_items = department_item::where('DELETE_FLG',False)
        ->where('company_id',$user_detail->company_id)
        ->get();

        return view('userDetail/index',compact('user_detail','users','department_items'));
    }

    //詳細表示
    //「/userDetail/{id}」へのアクセス
    public function show(){
        
        return view('userDetail/show', compact('user_detail'));
    }

    //新規作成画面への遷移
    //「/userDetail/create」へのアクセス
    public function create(){
        
        return view('userDetail/create', compact(''));
    }

    //新規作成処理
    //「/userDetail」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/userDetail");
    }

    //編集画面への遷移
    //「/userDetail/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('userDetail/edit', compact(''));
    }

    //編集処理
    //「/userDetail/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/userDetail");
    }

    //削除処理
    //「/userDetail/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/userDetail");
    }
}
