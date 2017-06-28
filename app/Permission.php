<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['permission_name', 'module_name', 'controller_name', 'method_name', 'parent_id'];

    /**
     * @return array
     */
    public static function getData()
    {
        $data = self::all()->toArray();
        return self::getTree($data);
    }

    /**
     * // 递归权限
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    private static function getTree($data, $pid = 0, $level = 0)
    {
        $tree = [];
        foreach ($data as $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level; //用来标记这个权限是第几级的
                $tree[] = $v;
                //找子分类
                $tree = array_merge($tree, self::getTree($data, $v['id'], $level + 1));
            }
        }
        return $tree;
    }

    /**
     * 验证管理员权限
     * @param $admin_id
     * @param $arr
     * @return bool
     */
    public static function checkPermission($admin_id, $arr)
    {
        $odds['a.admin_id'] = $admin_id;
        $odds['c.module_name'] = 'admin';
        $odds['c.controller_name'] = $arr[0];
        $odds['c.method_name'] = $arr[1];
        $state = DB::table('admin_roles as a')
            ->leftJoin('role_permissions as b', 'b.role_id', 'a.role_id')
            ->leftJoin('permissions as c', 'c.id', 'b.permission_id')
            ->where($odds)
            ->count();
        return $state > 0;
    }

    public static function getAdminPermission(Request $request)
    {
        // 先取出当前管理员所拥有的所有权限
        $admin_id = $request->session()->get('admin_id');
        if ($admin_id == 1) {
            $data = DB::table('permissions')->get();
        } else {
            // 取出当前管理员所在角色所拥有的权限
            $data = DB::table('admin_roles as a')
                ->select(DB::raw('DISTINCT c.id, c.permission_name, c.module_name, c.controller_name, c.method_name, c.parent_id'))
                ->leftJoin('role_permissions as b', 'b.role_id', 'a.role_id')
                ->leftJoin('permissions as c', 'c.id', 'b.permission_id')
                ->where('a.admin_id', $admin_id)
                ->get();
        }
        // 取出前两级权限
        $auth = [];
        foreach ($data as $val) {
            if ($val->parent_id == 0){
                // 再找这个顶级权限的子权限
                foreach ($data as $v){
                    if ($v->parent_id == $val->id){
                        $val->child[] = $v;
                    }
                }
                $auth[] = $val;
            }
        }
        return $auth;
    }
}
