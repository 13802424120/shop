<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $data = Permission::getAdminPermission($request);
        return view('index.index', ['data' => $data]);
    }

}
