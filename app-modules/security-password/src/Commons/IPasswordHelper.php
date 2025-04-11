<?php

namespace Eyegil\SecurityPassword\Commons;

interface IPasswordHelper
{
    public static function encryptPassword($user_id, $password, $userContext);
    public static function validatePassword($user_id, $password_, $password);
}
