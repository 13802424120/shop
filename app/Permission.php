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
                $tree = array_merge($tree,self::getTree($data, $v['id'], $level + 1));
            }
        }
        return $tree;
    }

    public static function checkPermission(Request $request)
    {
        // 超级管理员直接返回true
        $admin_id = $request->session()->get('id');
        if ($admin_id == 1) {
            return true;
        }
        $odds['a.admin_id'] = $admin_id;
        $odds['c.module_name'] = null;
        $odds['c.controller_name'] = null;
        $odds['c.method_name'] = null;
        $data = DB::table('admin_roles as a')
            ->leftJoin('role_permissions as b', 'b.role_id', 'a.role_id')
            ->leftJoin('permissions as c', 'c.id', 'b.permission_id')
            ->where($odds)
            ->count();
        return $data > 0;
    }
}
