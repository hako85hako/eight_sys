<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\user_detail;
use App\Models\company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\View\Factory;

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
        try{
            if(isset(Auth::user()->id)){
                $user_detail = user_detail::where('DELETE_FLG',False)
                        ->where('user_id',Auth::user()->id)
                        ->first();
                $company = company::where('DELETE_FLG',False)
                        ->where('id',$user_detail->company_id)
                        ->first();
                $company_name = $company->name;
            }else{
                $company_name = '企業情報取得失敗';
            }
            $this->viewFactory->share('company_name', $company_name);
        }catch (\Exception $e) {
            print($e->getMessage());
            $company_name = '会社情報取得失敗';
        }

        try{
            $user_detail = user_detail::where('DELETE_FLG',False)
                ->where('user_id',Auth::user()->id)
                ->first();
            $this->viewFactory->share('user_detail', $user_detail);
        }catch (\Exception $e) {
            print($e->getMessage());
            $user_detail = 'ログイン情報取得失敗';
        }
        return $next($request);
        
    }
}
