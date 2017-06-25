<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 插入管理员角色
     * @param $admin_id
     * @param $role_id
     */
    public static function insertAdminRole($admin_id, $role_id)
    {
        foreach ($role_id as $v) {
            self::insert(['admin_id' => $admin_id,'role_id' => $v]);
        }
    }
}
