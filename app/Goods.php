<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $fillable = ['name', 'brand_id', 'sort_id', 'is_putaway', 'describe', 'type_id', 'image'];
}
