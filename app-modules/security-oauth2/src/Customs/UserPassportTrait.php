<?php

namespace Eyegil\SecurityOauth2\Customs;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

trait UserPassportTrait
{
    public function validateForPassportPasswordGrant($password_)
    {
        if (class_exists('Eyegil\\SecurityPassword\\Models\\Password')) {
            $password = \Eyegil\SecurityPassword\Models\Password::find($this['id']);
            $customPasswordLogicClass = config("eyegil.security.password.validate");
            Log::info("TTTTTTTTTTTTTTTT");
            Log::info($this['id']);

            return $password && (class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::validatePassword($this['id'], $password_, $password['password']) : Hash::check($this['id'] . $password_, $password['password']));
        }

        return false;
    }
    public function findAndValidateForPassport($username, $password_)
    {
        if (class_exists('Eyegil\\SecurityPassword\\Models\\Password')) {
            $password = \Eyegil\SecurityPassword\Models\Password::find($username);

            $customPasswordLogicClass = config("eyegil.security.password.validate");
            $validated = $password && (class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::validatePassword($username, $password_, $password['password']) : Hash::check($username . $password_, $password['password']));

            if ($validated)
                return $this::find($username);
        }

        return null;
    }
}
