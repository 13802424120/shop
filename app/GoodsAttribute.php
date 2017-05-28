<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsAttribute extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 插入商品属性
     * @param $goods_id
     * @param $attribute_data
     */
    public static function insert_goods_attribute($goods_id, $attribute_data)
    {
        foreach ($attribute_data as $key => $val) {
            // 属性值数组去重
            $val = array_unique($val);
            foreach ($val as $v) {
                $data['attribute_value'] = $v;
                $data['attribute_id'] = $key;
                $data['goods_id'] = $goods_id;
                GoodsAttribute::insert($data);
            }
        }
    }
}
