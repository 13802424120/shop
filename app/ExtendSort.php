<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtendSort extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 添加商品扩展分类
     * @param $goods_id
     * @param $extend_sort_data
     */
    public static function insertExtendSort($goods_id, $extend_sort_data)
    {
        // 分类数据去重
        $extend_sort_data = array_unique($extend_sort_data);
        foreach ($extend_sort_data as $v) {
            self::insert(['sort_id' => $v, 'goods_id' => $goods_id]);
        }
    }

    /**
     * 删除商品扩展分类
     * @param $goods_id
     */
    public static function delExtendSort($goods_id)
    {
        if (is_array($goods_id)) {
            self::whereIn('goods_id', $goods_id)->delete();
        } else {
            self::where('goods_id', $goods_id)->delete();
        }
    }
}
