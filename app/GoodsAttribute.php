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
    public static function insertGoodsAttribute($attribute_data)
    {
        $goods_id = $attribute_data['id'];
        $attr_value = $attribute_data['attribute_value'];
        foreach ($attr_value as $key => $val) {
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

    /**
     * 修改商品属性
     * @param $attribute_data
     */
    public static function modifyGoodsAttribute($attribute_data)
    {
        $goods_id = $attribute_data['id'];
        $goods_attr_id = $attribute_data['goods_attr_id'];
        $attr_value = $attribute_data['attribute_value'];
        $i = 0;
        foreach ($attr_value as $k => $val) {
            foreach ($val as $v) {
                if ($goods_attr_id[$i] == '') {
                    $data['attribute_value'] = $v;
                    $data['attribute_id'] = $k;
                    $data['goods_id'] = $goods_id;
                    GoodsAttribute::insert($data);
                } else {
                    GoodsAttribute::where('id', $goods_attr_id[$i])
                        ->update(['attribute_value' => $v]);
                }
                $i++;
            }
        }
    }

    /**
     * 删除商品属性
     * @param $goods_id
     */
    public static function deleteGoodsAttribute($goods_id)
    {
        if (is_array($goods_id)) {
            $data = GoodsAttribute::whereIn('goods_id', $goods_id)->get();
            if ($data->first()) {
                GoodsAttribute::whereIn('goods_id', $goods_id)->delete();
            }

        } else {
            $data = GoodsAttribute::where('goods_id', $goods_id)->get();
            if ($data->first()) {
                GoodsAttribute::where('goods_id', $goods_id)->delete();
            }
        }

    }
}
