<?php

namespace App\Http\Middleware;

use App\Permission;
use Closure;
use Illuminate\Http\Request;

class Login
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
        $state = $request->session()->get('state');
        if ($state == 1) {
            $admin_id = $request->session()->get('admin_id');
            $path = $request->path();
            // 超级管理员直接通过
            if ($admin_id == 1 || $path == '/') {
                return $next($request);
            }
            $arr = explode('/',$path);
            $res = Permission::checkPermission($admin_id, $arr);
            return $res ? $next($request) : redirect('tips')->with('status', '无权访问！');
        }
        return redirect('login');
    }
}
