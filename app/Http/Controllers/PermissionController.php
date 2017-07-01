<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * 权限列表
     */
    public function lst()
    {
        $data = Permission::getData();
        return view('permission/lst', ['data' => $data]);
    }

    /**
     * 添加权限
     * @param Request $request
     */
    public function add(Request $request)
    {

        if ($request->isMethod('post')) {
            $res = Permission::create($request->all());
            if ($res) {
                return redirect('permission/lst');
            }
        }
        $data = Permission::getData();
        return view('permission/add', ['data' => $data]);
    }

    /**
     * 修改权限
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Permission::find($id);
        if ($request->isMethod('post')) {
            // 顶级分类不允许选择上级分类
            if ($res->parent_id == 0 && $request->parent_id != 0) {
                return redirect('permission/lst');
            }
            if ($res->update($request->all())) {
                return redirect('permission/lst');
            }
        }
        $data = Permission::getData();
        return view('permission/edit', ['res' => $res, 'data' => $data]);
    }

    /**
     * 删除权限
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        if (Permission::destroy($id)) {
            return redirect('permission/lst');
        }
    }
}
