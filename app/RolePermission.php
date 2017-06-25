<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * 插入角色权限
     * @param $role_id
     * @param $permission_id
     */
    public static function insertRolePermission($role_id, $permission_id)
    {
        foreach ($permission_id as $v) {
            self::insert(['role_id' => $role_id,'permission_id' => $v]);
        }
    }
}
