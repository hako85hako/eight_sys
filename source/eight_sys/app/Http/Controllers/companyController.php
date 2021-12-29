<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class companyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    //初期アクセス
    //「/company」へのGETアクセス
    public function index(){
        
        return view('company/index', compact(''));
    }

    //詳細表示
    //「/company/{id}」へのアクセス
    public function show(){
        
        return view('company/show', compact(''));
    }

    //新規作成画面への遷移
    //「/company/create」へのアクセス
    public function create(){
        
        return view('company/create', compact(''));
    }

    //新規作成処理
    //「/company」へのPOSTアクセス
    public function store(Request $request){
        
        return redirect("/company");
    }

    //編集画面への遷移
    //「/company/{id}/edit」へのアクセス
    public function edit($id){
        
        return view('company/edit', compact(''));
    }

    //編集処理
    //「/company/{id}」へのPUTアクセス
    public function update(Request $request, $id){
        
        return redirect("/company");
    }

    //削除処理
    //「/company/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/company");
    }
}
