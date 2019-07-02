<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(request()->ajax() && !session('user_id')){
            echo json_encode(['code'=>-1]);exit;
        }
        if(!session('user_id')){
           return redirect('login');
        }
        $userInfo = getUserInfo(session('user_id'));
        if(!checkLoginToken(session('login_token'),$userInfo['login_token'])){
            $request->session()->flush();
            return redirect('login');
        }
        return $next($request);
    }
}
