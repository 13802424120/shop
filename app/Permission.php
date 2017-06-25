<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
