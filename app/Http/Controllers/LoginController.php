<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $captcha = captcha_src();
        if ($request->isMethod('post')) {
            $code = mb_strtolower($request->code, 'UTF-8');
            $data = $request->session()->get('captcha');
            if ($code == $data['code']) {
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
        return view('login.index', ['captcha' => $captcha]);
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