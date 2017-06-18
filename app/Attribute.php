<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = ['attr_name', 'attr_type', 'option_values', 'type_id'];

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
                GoodsAttr::where('type_id', $type_id)->delete();
            }
        }

    }


}
