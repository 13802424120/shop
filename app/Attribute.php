<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 删除类型关联属性
     * @param $type_id
     */
    public static function deleteTypeAttribute($type_id)
    {
        if (is_array($type_id)) {
            $data = Attribute::whereIn('type_id', $type_id)->get();
            if ($data->first()) {
                Attribute::whereIn('type_id', $type_id)->delete();
            }

        } else {
            $data = Attribute::where('type_id', $type_id)->get();
            if ($data->first()) {
                GoodsAttribute::where('type_id', $type_id)->delete();
            }
        }

    }
}
