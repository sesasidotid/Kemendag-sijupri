<?php

namespace Eyegil\SecurityPassword\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityPassword\Dtos\PasswordDto;
use Eyegil\SecurityPassword\Models\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function findByUserId($user_id)
    {
        return Password::findOrThrowNotFound($user_id);
    }
    public function findByUserIdV2($user_id)
    {
        return Password::find($user_id);
    }

    public function validatePassword($user_id, $password_): bool
    {
        $password = $this->findByUserId($user_id);
        $customPasswordLogicClass = config("eyegil.security.password.validate");
        

        if (class_exists($customPasswordLogicClass)) {
            if (!$password || !$customPasswordLogicClass::validatePassword($user_id, $password_, $password->password)) {
                return false;
            }
        } else {
            if (!$password || !Hash::check($user_id . $password_, $password->password)) {
                return false;
            }
        }

        return true;
    }

    public function save(PasswordDto $passwordDto)
    {
        DB::transaction(function () use ($passwordDto) {
            $userContext = user_context();
            $customPasswordLogicClass = config("eyegil.security.password.encrypt");

            $password = $this->findByUserIdV2($passwordDto->user_id) ?? new Password();
            $password->user_id = $passwordDto->user_id;
            $password->password = $passwordDto->password;
            $password->password = class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::encryptPassword($passwordDto->user_id,  $passwordDto->password, $userContext) : bcrypt($passwordDto->user_id . $passwordDto->password);
            $password->created_by = $userContext->id;
            $password->save();
        });
    }

    public function update(PasswordDto $passwordDto)
    {
        if (!$this->validatePassword($passwordDto->user_id, $passwordDto->old_password)) {
            throw new BusinessException("invalid credential", "PSS-00001");
        }

        DB::transaction(function () use ($passwordDto) {
            $userContext = user_context();
            $password = $this->findByUserId($passwordDto->user_id);
            $customPasswordLogicClass = config("eyegil.security.password.encrypt");

            $password->password = class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::encryptPassword($passwordDto->user_id,  $passwordDto->password, $userContext) : bcrypt($passwordDto->user_id . $passwordDto->password);
            $password->updated_by = $userContext->id;
            $password->save();
        });
    }

    public function forceUpdate(PasswordDto $passwordDto)
    {
        DB::transaction(function () use ($passwordDto) {
            $userContext = user_context();
            $password = $this->findByUserId($passwordDto->user_id);
            $customPasswordLogicClass = config("eyegil.security.password.encrypt");

            $password->password = class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::encryptPassword($passwordDto->user_id,  $passwordDto->password, $userContext) : bcrypt($passwordDto->user_id . $passwordDto->password);
            $password->updated_by = $userContext->id;
            $password->save();
        });
    }

    public function forgotUpdate(PasswordDto $passwordDto)
    {
        DB::transaction(function () use ($passwordDto) {
            $password = $this->findByUserId($passwordDto->user_id);
            $customPasswordLogicClass = config("eyegil.security.password.encrypt");

            $password->password = class_exists($customPasswordLogicClass) ? $customPasswordLogicClass::encryptPassword($passwordDto->user_id,  $passwordDto->password, null) : bcrypt($passwordDto->user_id . $passwordDto->password);
            $password->updated_by = $passwordDto->user_id . "(forgot password)";
            $password->save();
        });
    }
}
