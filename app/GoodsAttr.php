<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodsAttr extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 插入商品属性
     * @param $goods_id
     * @param $attr_value
     */
    public static function insertGoodsAttr($goods_id, $attr_value)
    {
        foreach ($attr_value as $k => $val) {
            // 属性值数组去重
            $val = array_unique($val);
            foreach ($val as $v) {
                GoodsAttr::insert(['attr_value' => $v, 'attr_id' => $k, 'goods_id' => $goods_id]);
            }
        }
    }

    /**
     * 修改商品属性
     * @param $attribute_data
     */
    public static function modifyGoodsAttr($attribute_data)
    {
        $goods_id = $attribute_data['id'];
        $goods_attr_id = $attribute_data['goods_attr_id'];
        $attr_value = $attribute_data['attr_value'];
        $i = 0;
        foreach ($attr_value as $k => $val) {
            foreach ($val as $v) {
                if ($goods_attr_id[$i] == '') {
                    GoodsAttr::insert(['attr_value' => $v, 'attr_id' => $k, 'goods_id' => $goods_id]);
                } else {
                    GoodsAttr::where('id', $goods_attr_id[$i])
                        ->update(['attr_value' => $v]);
                }
                $i++;
            }
        }
    }

    /**
     * 删除商品属性
     * @param $goods_id
     */
    public static function deleteGoodsAttr($goods_id)
    {
        if (is_array($goods_id)) {
            $data = GoodsAttr::whereIn('goods_id', $goods_id)->get();
            if ($data->first()) {
                GoodsAttr::whereIn('goods_id', $goods_id)->delete();
            }

        } else {
            $data = GoodsAttr::where('goods_id', $goods_id)->get();
            if ($data->first()) {
                GoodsAttr::where('goods_id', $goods_id)->delete();
            }
        }

    }
}
