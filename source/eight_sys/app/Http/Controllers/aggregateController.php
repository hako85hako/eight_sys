<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use Illuminate\Support\Facades\Auth;

class aggregateController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/aggregate」へのGETアクセス
    public function index(){
        $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
        
        return view('aggregate/index',compact('user_detail'));
    }

    //詳細表示
    //「/aggregate/{id}」へのアクセス
    public function show(){
        
        return view('aggregate/show', compact('user_detail'));
    }

    //新規作成画面への遷移
    //「/aggregate/create」へのアクセス
    public function create(){
        
        return view('aggregate/create', compact(''));
    }

    //新規作成処理
    //「/aggregate」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/aggregate");
    }

    //編集画面への遷移
    //「/aggregate/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('aggregate/edit', compact(''));
    }

    //編集処理
    //「/aggregate/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/aggregate");
    }

    //削除処理
    //「/aggregate/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/aggregate");
    }
}
