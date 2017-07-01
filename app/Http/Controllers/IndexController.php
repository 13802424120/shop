<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

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
