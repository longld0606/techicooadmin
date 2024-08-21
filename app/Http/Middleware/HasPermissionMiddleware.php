<?php

namespace App\Http\Middleware;

use App\Models\Logs;
use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class HasPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */




    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return $next($request);
        }
        $user = $request->user();
        $action = Route::getCurrentRoute()->getAction();
        $_controller = "";
        if (array_key_exists('controller', $action)) {
            $_controller =  $action['controller']; 
        }
        if (!empty($_controller)) { 
            $controller = str_replace(['App\Http\Controllers\\'], "", $_controller);
            // check chưa phân quyền cho chức năng này => pass
            $exists = Permission::where("name",$controller)->where("guard_name",'admin')->exists();
            if (!$exists) return $next($request);
            // cho phép vào home với mọi quyền
            if(str_contains($controller, "DashboardController")) return $next($request);

            // kiểm tra sử dụng Budvar thì cần quyền budvar và các quyền chi tiết của budvar
            // if(str_contains($controller, "\\Budvar\\") && $user->hasPermissionTo('Budvar', 'admin')) return $next($request);
            
            // kiểm tra sử dụng Techicoo thì cần quyền Techicoo và các quyền chi tiết của Techicoo
            // if(str_contains($controller, "\\Techicoo\\") && $user->hasPermissionTo('Techicoo', 'admin')) return $next($request);
            
            // kiểm tra sử dụng Administrator thì cần quyền budvar và các quyền chi tiết của Administrator
            // if(str_contains($controller, "\\Administrator\\") && $user->hasPermissionTo('Administrator', 'admin')) return $next($request);

            // check quyền
            if(!$user->hasPermissionTo($controller, 'admin')){
                if($request->ajax())
                    return $next(\App\Common\Response::error('Không có quyền thực hiện thao tác này!')); 
                return abort(403);
            }
        } 
        return $next($request);
    }
}
