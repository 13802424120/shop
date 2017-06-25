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
    public static function delTypeAttribute($type_id)
    {
        if (is_array($type_id)) {
            $data = self::whereIn('type_id', $type_id)->get();
            if ($data->first()) {
                self::whereIn('type_id', $type_id)->delete();
            }

        } else {
            $data = Attribute::where('type_id', $type_id)->get();
            if ($data->first()) {
                self::where('type_id', $type_id)->delete();
            }
        }

    }


}
