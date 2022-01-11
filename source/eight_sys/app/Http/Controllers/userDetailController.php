<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyTools\dateControllTools;
use App\Models\attendance_detail;
use App\Models\user_detail;
use App\Models\User;
use App\Models\department_item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


/**
 * user_detailsに関するController
 * 
 * 
 */
class userDetailController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * 初期アクセス
     * 「/userDetail」へのGETアクセス
     * 
     * @return ./userDetail/index
     */
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

        return view('./userDetail/index',compact('users','department_items'));
    }

    //詳細表示
    //「/userDetail/{id}」へのアクセス
    public function show(){
        
    }

    /**
     * 新規作成画面への遷移
     * 「/userDetail/create」へのアクセス
     * 
     * @return userEdit/edit
     */
    public function create(){
        $new_user = new user_detail();
        $user_detail = user_detail::where('DELETE_FLG',False)
        ->where('user_id',Auth::user()->id)
        ->first();
        $department_items = department_item::where('DELETE_FLG',False)
        ->where('company_id',$user_detail->company_id)
        ->get();
        return view('userEdit/edit', compact('new_user','department_items'));
    }

    /**
     * 新規作成処理
     * 「/userDetail」へのPOSTアクセス
     * 
     * 
     * 
     * @return /userDetailへのリダイレクト
     */
    public function store(Request $request){
        //トランザクション開始
        DB::beginTransaction();
        try{
            //登録した人の情報
            $user_detail = user_detail::where('DELETE_FLG',False)
            ->where('user_id',Auth::user()->id)
            ->first();

            //登録する人の情報
            //User
            $new_User = new User();
            $new_User->name = $request->name;
            $new_User->email = $request->email;
            $new_User->password = Hash::make($new_User->email.'123');
            $new_User->save();
            //user_detail
            $new_user_detail = new user_detail();
            $new_user_detail->user_id = $new_User->id;
            $new_user_detail->date_inf = date('Y-m-d');
            $new_user_detail->company_id = $user_detail->company_id;
            $new_user_detail->name = $request->name;
            $new_user_detail->role = 'user';
            $new_user_detail->hire_date = $request->hire_date;
            $new_user_detail->department_id = $request->department;

            $new_user_detail->CREATE_USER = Auth::user()->name;
            $new_user_detail->UPDATE_USER = Auth::user()->name;
            $new_user_detail->CREATE_USER_ID = Auth::user()->id;
            $new_user_detail->UPDATE_USER_ID = Auth::user()->id;
            $new_user_detail->save();
            //コミット処理
            DB::commit();
        }catch (\Exception $e) {
            //ロールバック処理
            DB::rollback();
            //ログ出力
            \Log::error($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        return redirect("/userDetail");
    }


    /**
     * 編集画面への遷移
     * 「/userDetail/{id}/edit」へのアクセス
     * 
     * @return /userEdit/store
     */
    public function edit($id){
        DB::beginTransaction();
        try{
            $user_detail = user_detail::where('DELETE_FLG',False)
            ->where('user_id',Auth::user()->id)
            ->first();

            $edit_user_detail = user_detail::where('DELETE_FLG',False)
            ->where('id',$id)
            ->first();
            $edit_user = User::where('id',$edit_user_detail->user_id)
            ->first();
            $userEmail = $edit_user->email;
            $department_items = department_item::where('DELETE_FLG',False)
            ->where('company_id',$user_detail->company_id)
            ->get();
        }catch (\Exception $e) {
            //ロールバック処理
            DB::rollback();
            //ログ出力
            \Log::error($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }

        return view('/userEdit/store', 
        compact('userEmail','department_items',
                'edit_user_detail'));
    }


    /**
     * 編集処理
     * 「/userDetail/{id}」へのPUTアクセス
     * 
     * 
     * @return redirect("/userDetail");
     */
    public function update(Request $request, $id){

        DB::beginTransaction();
        try{
            //対象ユーザーの情報
            if(isset($request->name)){
                $select_User = User::where('id',$request->user_id)
                        ->first();
                $select_User->name = $request->name;
                $select_User->email = $request->email;
                $select_User->save();
            }
            //user_detail
            $select_user_detail = user_detail::where('DELETE_FLG',False)
            ->where('id',$id)
            ->first();
            $select_user_detail->department_id = $request->department;
            $select_user_detail->name = $request->name;
            $select_user_detail->hire_date = $request->hire_date;
            $select_user_detail->CREATE_USER = Auth::user()->name;
            $select_user_detail->UPDATE_USER = Auth::user()->name;
            $select_user_detail->CREATE_USER_ID = Auth::user()->id;
            $select_user_detail->UPDATE_USER_ID = Auth::user()->id;
            $select_user_detail->save();
            DB::commit();
        }catch (\Exception $e) {
            //ロールバック処理
            DB::rollback();
            //ログ出力
            \Log::error($e);
            print($e->getMessage());
            print('DBcommit失敗');
        }
        return redirect("/userDetail");
    }

    //削除処理
    //「/userDetail/{id}」へのDELETEアクセス
    public function destroy($id){
        
        return redirect("/userDetail");
    }
}