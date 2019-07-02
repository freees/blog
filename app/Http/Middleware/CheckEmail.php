<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckEmail
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
        $user = getUserInfo(session('user_id'));
        if(request()->ajax() && $user['email_is_check'] != 1){
            echo json_encode(['code'=>-2]);exit;
        }
        if($user['email_is_check'] != 1){
            return redirect('check_email');
        }
        return $next($request);
    }
}
