<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\AdminRole;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * 管理员列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lst()
    {
        $data = DB::table('admins as a')
            ->select('a.id', 'a.username', DB::raw('GROUP_CONCAT(c.role_name) as role_name'))
            ->leftJoin('admin_roles as b', 'a.id', 'b.admin_id')
            ->leftJoin('roles as c', 'b.role_id', 'c.id')
            ->groupBy('a.id')
            ->paginate(10);
        return view('admin/lst', ['data' => $data]);
    }

    /**
     * 添加管理员
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request['password'] = md5($request->password);
            $res = Admin::create($request->all());
            if ($res) {
                // 添加管理员角色
                $admin_id = $res->id;
                $role_id = $request->role_id;
                AdminRole::insertAdminRole($admin_id, $role_id);
                return redirect('admin/lst');
            }
        }
        $data = Role::all();
        return view('admin/add', ['data' => $data]);
    }

    /**
     * 修改管理员
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Admin::find($id);
        if ($request->isMethod('post')) {
            if (!empty($request->password)) {
                $request['password'] = md5($request->password);
            } else {
                unset($request['password']);
            }
            if ($res->update($request->all())) {
                // 先删除原管理员角色数据
                AdminRole::where('admin_id', $id)->delete();
                // 再添加新管理员角色数据
                $role_id = $request->role_id;
                AdminRole::insertAdminRole($id, $role_id);
                return redirect('admin/lst');
            }
        }
        $role_data = Role::all();
        $admin_role_data = AdminRole::where('admin_id', $id)->pluck('role_id')->toArray();
        return view('admin/edit',
            ['res' => $res,
                'role_data' => $role_data,
                'admin_role_data' => $admin_role_data,
            ]
        );
    }

    /**
     * 删除管理员
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        if ($id != 1) {
            Admin::destroy($id);
            // 删除管理员角色数据
            AdminRole::where('admin_id', $id)->delete();
        }
        return redirect('admin/lst');
    }
}
