<?php

namespace App\Http\Middleware;

use Closure;
use \Datetime;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\MyTools\tableItemControllTools;

class HeaderMiddleware
{
    public function __construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //company_name取得処理
        try{
            if(isset(Auth::user()->id)){
                $user_detail = tableItemControllTools::get_userDetail_from_userId(Auth::user()->id);
                $company = tableItemControllTools::get_company_from_id($user_detail->company_id);
                $company_name = $company->name;
            }else{
                $company_name = '企業情報取得失敗';
            }
            $this->viewFactory->share('company_name', $company_name);
        }catch (\Exception $e) {
            tableItemControllTools::DBrollback($e);
            print($e->getMessage());
            $company_name = '会社情報取得失敗';
        }

        //user_detail取得処理
        try{
            $user_detail = tableItemControllTools::get_userDetail_from_userId(Auth::user()->id);
            $this->viewFactory->share('user_detail', $user_detail);
        }catch (\Exception $e) {
            tableItemControllTools::DBrollback($e);
            print($e->getMessage());
            $user_detail = 'ログイン情報取得失敗';
        }

        

        //有給休暇取得判定処理
        try{
            $this->judgeGiveRequestRest();
        }catch (\Exception $e) {
            tableItemControllTools::DBrollback($e);
            //print($e->getMessage());
            //print('有給付与処理失敗');
        }

        return $next($request);
        
    }


    private function giveRequestRest($user_detail_id,$give_date){
        $user_requestRest_log = tableItemControllTools::create_userRequestRestLog();
        $user_requestRest_log->user_detail_id = $user_detail_id;
        $user_requestRest_log->get_date = new DateTime($give_date);
        $user_requestRest_log->CREATE_USER = 'admin';
        $user_requestRest_log->UPDATE_USER = 'admin';
        $user_requestRest_log->CREATE_USER_ID = '0';
        $user_requestRest_log->UPDATE_USER_ID = '0';
        $user_requestRest_log -> save();
    }


    private function judgeGiveRequestRest(){
            //ユーザー詳細情報を取得
            $user_detail = tableItemControllTools::get_userDetail_from_userId(Auth::user()->id);
            //入社日を取得
            $hire_date = $user_detail->hire_date;
            //経過日数を算出
            date_default_timezone_set('Asia/Tokyo');
            $today = new DateTime('now');
            $day = new DateTime($hire_date);
            $diff = $day->diff($today);

            //前回取得した有給休暇の情報を取得
            $before_requestRest = tableItemControllTools::get_companyRequestRestSetting_from_beforeRequestRestId($user_detail->before_requestRest_id);
            
            if(isset($before_requestRest)){
                //取得歴がある場合
                //次回の付与日を取得
                $next_date = tableItemControllTools::get_companyRequestRestSetting_from_companyId_and_overPassDate_minimum(
                    $user_detail->company_id,
                    '>',
                    $before_requestRest->pass_date,
                    'pass_date'
                );
                if(!isset($next_date)){
                    $max_id = tableItemControllTools::get_companyRequestRestSetting_max('id');
                    $user_requestRest_log = tableItemControllTools::get_companyRequestRestSetting_id($max_id);
                    $next_give_date = date('Y-m-d', strtotime($user_requestRest_log->give_date." 12 month"));
                    $day2 = new DateTime($next_give_date);
                    $diff2 = $day2->diff($today);
                    $next_date = $diff2->format('%a')/12;
                }
            }else{
                //取得歴がない場合
                //最初の付与日を取得
                $next_date = tableItemControllTools::get_companyRequestRestSetting_from_companyId_minimunSelect($user_detail->company_id,'pass_date');
            }
            //付与日に到達しているか判定
            if($next_date < $diff->format('%a')/365 ){
                $company_requestRest_setting = tableItemControllTools::get_companyRequestRestSetting_from_companyId_add_one_Select(
                        $user_detail->company_id,
                        'pass_date',
                        $next_date
                );
                if(!isset($company_requestRest_setting)){
                    $company_requestRest_setting = tableItemControllTools::get_companyRequestRestSetting_from_companyId_add_one_Select(
                            $user_detail->company_id,
                            'id', 
                            $user_detail->before_requestRest_id
                    );
                }
                //有給付与処理
                for ($i = 0; $i < $company_requestRest_setting->give_date; $i += 1){
                    $this->giveRequestRest($user_detail->id,date('Y-m-d', strtotime($hire_date." ".($next_date * 12)." month")));
                }
                $user_detail->before_requestRest_id =  $company_requestRest_setting->id;
                $user_detail->save(); 
            }
    }
}
