<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user();
        if ($user && $user->type == 'admin') {
            return $next($request);
        }

        $user_web = Auth::guard('web')->user();
        if ($user_web) {
            Auth::guard('web')->logout();
        }
        if( $request->ajax()) return \App\Common\Response::success('Tài khoản không hợp lệ vui lòng thử lại!');
        return redirect()->route('admin.login');
        
        //  return redirect()->back()->withInput()->withErrors(['Tài khoản không hợp lệ vui lòng thử lại.']);
    }
}
