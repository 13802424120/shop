<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 后台首页
     * @param Request $request
     */
    public function index(Request $request)
    {
        $data = Permission::getAdminPermission($request);
        return view('index.index', ['data' => $data]);
    }

}
