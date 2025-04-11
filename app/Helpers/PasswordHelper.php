<?php

namespace App\Helpers;

use Eyegil\SecurityPassword\Commons\IPasswordHelper;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordHelper implements IPasswordHelper
{
    public static function encryptPassword($user_id, $password, $userContext)
    {
        return Crypt::encrypt(Hash::make($password));
    }

    public static function validatePassword($user_id, $password_, $password)
    {
        return Hash::check($password_, Crypt::decrypt($password));
    }
}
