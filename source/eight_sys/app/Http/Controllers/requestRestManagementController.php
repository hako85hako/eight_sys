<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use Illuminate\Support\Facades\Auth;

class requestRestManagementController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/requestRestManagement」へのGETアクセス
    public function index(){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        return view('requestRestManagement/index',compact('user_detail'));
    }

    //詳細表示
    //「/requestRestManagement/{id}」へのアクセス
    public function show(){
        
        return view('requestRestManagement/show', compact('user_detail'));
    }

    //新規作成画面への遷移
    //「/requestRestManagement/create」へのアクセス
    public function create(){
        
        return view('requestRestManagement/create', compact(''));
    }

    //新規作成処理
    //「/requestRestManagement」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/requestRestManagement");
    }

    //編集画面への遷移
    //「/requestRestManagement/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('requestRestManagement/edit', compact(''));
    }

    //編集処理
    //「/requestRestManagement/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/requestRestManagement");
    }

    //削除処理
    //「/requestRestManagement/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/requestRestManagement");
    }
}
