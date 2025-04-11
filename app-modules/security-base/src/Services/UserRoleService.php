<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\Models\UserRole;
use Illuminate\Support\Facades\DB;

class UserRoleService
{

    public function findAll()
    {
        return UserRole::all();
    }

    public function findById(string $id): UserRole
    {
        return UserRole::findOrThrowNotFound($id);
    }

    public function findByUserId(string $user_id)
    {
        return UserRole::where("user_id", $user_id)->get();
    }

    public function findByRoleCode($role_code)
    {
        return UserRole::where("role_code", $role_code)->get();
    }

    public function save(UserDto $userDto): void
    {
        $userContext = user_context();
        DB::transaction(function () use ($userDto, $userContext) {
            foreach ($userDto->role_code_list as $key => $role_code) {
                $userRole = new UserRole();
                $userRole->user_id = $userDto->id;
                $userRole->role_code = $role_code;
                $userRole->created_by = $userContext->id;
                $userRole->saveWithUuid();
            }
        });
    }

    public function update(UserDto $userDto): void
    {
        DB::transaction(function () use ($userDto) {
            UserRole::where("user_id", $userDto->id)->delete();
            $this->save($userDto);
        });
    }
}
