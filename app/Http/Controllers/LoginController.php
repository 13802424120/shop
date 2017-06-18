<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $code = mb_strtolower($request->code, 'UTF-8');
            $captcha = $request->session()->get('captcha.code');
            if ($code == $captcha) {
                $odds['username'] = $request->username;
                $odds['password'] = md5($request->password);
                $res = Admin::where($odds)->get();
                if ($res->first()) {
                    $request->session()->put('state', 1);
                    return redirect('/');
                }
                echo "<script>alert('用户名或密码不正确！');</script>";
            } else {
                $request->session()->put('state', 0);
                echo "<script>alert('验证码不正确！');</script>";
            }
        }
        return view('login.index', ['captcha' => captcha_src()]);
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->forget('state');
        return redirect('login');
    }
}