<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use Illuminate\Support\Facades\Auth;

class requestRestController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/requestRest」へのGETアクセス
    public function index(){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        return view('requestRest/index',compact('user_detail'));
    }

    //詳細表示
    //「/requestRest/{id}」へのアクセス
    public function show(){
        
        return view('requestRest/show', compact('user_detail'));
    }

    //新規作成画面への遷移
    //「/requestRest/create」へのアクセス
    public function create(){
        
        return view('requestRest/create', compact(''));
    }

    //新規作成処理
    //「/requestRest」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/requestRest");
    }

    //編集画面への遷移
    //「/requestRest/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('requestRest/edit', compact(''));
    }

    //編集処理
    //「/requestRest/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/requestRest");
    }

    //削除処理
    //「/requestRest/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/requestRest");
    }
}
