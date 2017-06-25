<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * 角色列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $data = Role::paginate(10);
        return view('role/lst', ['data' => $data]);
    }

    /**
     * 添加角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Role::create($request->all());
            if ($res) {
                return redirect('role/lst');
            }
        }
        return view('role/add');
    }

    /**
     * 修改角色
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Role::find($id);
        if ($request->isMethod('post')) {
            if ($res->update($request->all())) {
                return redirect('role/lst');
            }
        }
        return view('role/edit', ['res' => $res]);
    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function del(Request $request)
    {
        $id = $request->id;
        if (Role::destroy($id)) {
            return redirect('role/lst');
        }
    }
}
