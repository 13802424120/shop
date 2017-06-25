<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $captcha = captcha_src();
        return view('login.index', ['captcha' => $captcha]);
    }

    /**
     * 登录验证
     * @param Request $request
     * @return string
     */
    public function checkLogin(Request $request)
    {
        $code = mb_strtolower($request->code, 'UTF-8');
        $captcha = $request->session()->get('captcha.code');
        if ($code == $captcha) {
            $odds['username'] = $request->username;
            $odds['password'] = md5($request->password);
            $res = Admin::where($odds)->first();
            if ($res) {
                $request->session()->put('id', $res->id);
                $request->session()->put('state', 1);
                return json_encode(['code' => 1, 'message' =>'登录成功！']);
            }
            return json_encode(['code' => 0, 'message' =>'用户名或密码不正确！']);
        }
        return json_encode(['code' => 0, 'message' =>'验证码不正确！']);
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