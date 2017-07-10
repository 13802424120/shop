<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * 角色列表
     */
    public function lst()
    {
        $data = DB::table('roles as a')
            ->select('a.id', 'a.role_name', DB::raw('GROUP_CONCAT(c.permission_name) as permission_name'))
            ->leftJoin('role_permissions as b', 'a.id', 'b.role_id')
            ->leftJoin('permissions as c', 'b.permission_id', 'c.id')
            ->groupBy('a.id')
            ->get();
        return view('role/lst', ['data' => $data]);
    }

    /**
     * 添加角色
     * @param Request $request
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $res = Role::create($request->all());
            if ($res) {
                // 添加角色权限
                $role_id = $res->id;
                $permission_id = $request->permission_id;
                RolePermission::insertRolePermission($role_id, $permission_id);
                return redirect('role/lst');
            }
        }
        $data = Permission::getData();
        return view('role/add', ['data' => $data]);
    }

    /**
     * 修改角色
     * @param Request $request
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $res = Role::find($id);
        if ($request->isMethod('post')) {
            if ($res->update($request->all())) {
                // 先删除原角色权限数据
                RolePermission::where('role_id', $id)->delete();
                // 再添加新角色权限数据
                $permission_id = $request->permission_id;
                RolePermission::insertRolePermission($id, $permission_id);
                return redirect('role/lst');
            }
        }
        $permission_data = Permission::getData();
        $role_permission_data = RolePermission::where('role_id', $id)->pluck('permission_id')->toArray();
        return view('role/edit', ['res' => $res,
            'permission_data' => $permission_data,
            'role_permission_data' => $role_permission_data
        ]);
    }

    /**
     * 删除角色
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->id;
        if (Role::destroy($id)) {
            // 删除角色权限数据
            RolePermission::where('role_id', $id)->delete();
            return redirect('role/lst');
        }
    }
}
