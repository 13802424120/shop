<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 添加商品库存量
     * @param $stocks_data
     */
    public static function addStock($stocks_data)
    {
        $goods_id = $stocks_data['id'];
        $stock = $stocks_data['stock'];
        $price = $stocks_data['price'];
        if (!empty($stocks_data['goods_attr_id'])) {
            $goods_attr_id = $stocks_data['goods_attr_id'];
            // 先计算商品属性id和库存量的比例
            $attr_count = count($goods_attr_id);
            $stock_count = count($stock);
            $ratio = $attr_count / $stock_count;
            $num = 0;
        }
        // 循环库存量
        foreach ($stock as $k => $val) {
            $goods_attribute_id = '';
            if (!empty($ratio)) {
                // 把下面取出来的id放这里
                $attr_id = [];
                // 从商品属性id中取出$ratio个，循环一次取一个
                for ($i = 0; $i < $ratio; $i++) {
                    $attr_id[] = $goods_attr_id[$num];
                    $num++;
                }
                // 先升序排列
                sort($attr_id, SORT_NUMERIC);
                // 把取出来的商品属性id转换成字符串
                $goods_attribute_id = implode(',', $attr_id);
            }
            Stock::insert(
                ['goods_id' => $goods_id,
                    'stock' => $val,
                    'price' => $price[$k],
                    'goods_attr_id' => $goods_attribute_id
                ]
            );
        }
    }

    /**
     * 删除商品库存量
     * @param $goods_id
     */
    public static function delStock($goods_id)
    {
        if (is_array($goods_id)) {
            Stock::whereIn('goods_id', $goods_id)->delete();
        } else {
            Stock::where('goods_id', $goods_id)->delete();
        }
    }
}
