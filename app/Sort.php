<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['sort_name', 'parent_id'];

    /**
     * 获取分类树状数据
     * @return array
     */
    public static function getTreeData()
    {
        $data = self::all()->toArray();
        return self::getTree($data);
    }

    /**
     * // 递归分类
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    private static function getTree($data, $pid = 0, $level = 0)
    {
        static $tree = [];
        foreach ($data as $v) {
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level; //用来标记这个分类是第几级的
                $tree[] = $v;
                //找子分类
                self::getTree($data, $v['id'], $level + 1);
            }
        }
        return $tree;
    }

    /**
     * 获取分类下的所有子分类
     * @param $parent_id
     * @return mixed
     */
    public static function getChildData($parent_id)
    {
        // 取出所有的分类
        $data = self::all()->toArray();
        // 递归从所有的分类中挑出子分类的id
        return self::getChild($data, $parent_id);
    }

    /**
     * 递归子分类
     * @param $data
     * @param $parent_id
     * @return array
     */
    public static function getChild($data, $parent_id)
    {
        static $child = [];
        // 循环所有的分类找子分类
        foreach ($data as $v) {
            if ($v['parent_id'] == $parent_id) {
                $child[] = $v['id'];
                // 再找这个$v的子分类
                self::getChild($data, $v['id']);
            }
        }
        return $child;
    }
}
