<?php

namespace App;

use Cartalyst\Sentinel\Users\EloquentUser;
use Sentinel;

class Admin extends EloquentUser
{
    protected $table = 'users';

    public static function upgradeUser($id, $permissions)
    {
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')) {
            return false;
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission => $value) {
                $user->updatePermission($permission, $value, true)->save();
            }

            return true;
        } else {
            $user->addPermission($permission)->save();

            return true;
        }

        return false;
    }

    public static function downgradeUser($id, $permissions)
    {
        $user = Sentinel::findById($id);
        if ($user->hasAccess('admin.*')) {
            return false;
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission => $value) {
                $user->updatePermission($permission, false, true)->save();
            }

            return true;
        } else {
            dd($permissions);
            $user->removePermission($permissions)->save();

            return true;
        }

        return false;
    }
}
