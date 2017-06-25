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
                self::insert(['attr_value' => $v, 'attr_id' => $k, 'goods_id' => $goods_id]);
            }
        }
    }

    /**
     * 修改商品属性
     * @param $attribute_data
     */
    public static function modifyGoodsAttr($attr_data)
    {
        $goods_id = $attr_data['id'];
        $goods_attr_id = $attr_data['goods_attr_id'];
        $attr_value = $attr_data['attr_value'];
        $i = 0;
        foreach ($attr_value as $k => $val) {
            foreach ($val as $v) {
                if ($goods_attr_id[$i] == '') {
                    self::insert(['attr_value' => $v, 'attr_id' => $k, 'goods_id' => $goods_id]);
                } else {
                    self::where('id', $goods_attr_id[$i])
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
    public static function delGoodsAttr($goods_id)
    {
        if (is_array($goods_id)) {
            $data = self::whereIn('goods_id', $goods_id)->get();
            if ($data->first()) {
                self::whereIn('goods_id', $goods_id)->delete();
            }

        } else {
            $data = self::where('goods_id', $goods_id)->get();
            if ($data->first()) {
                self::where('goods_id', $goods_id)->delete();
            }
        }

    }
}
