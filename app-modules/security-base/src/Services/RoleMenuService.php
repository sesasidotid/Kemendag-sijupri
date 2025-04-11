<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\RoleDto;
use Eyegil\SecurityBase\Models\RoleMenu;
use Illuminate\Support\Facades\DB;

class RoleMenuService
{
    public function __construct()
    {
    }

    public function findAll()
    {
        return RoleMenu::all();
    }

    public function findById(string $id): RoleMenu
    {
        return RoleMenu::findOrThrowNotFound($id);
    }

    public function findByRoleCodeList(array $roleCodeList)
    {
        return RoleMenu::whereIn("role_code", $roleCodeList)->get();
    }

    public function save(RoleDto $roleDto): void
    {
        DB::transaction(function () use ($roleDto) {
            $userContext = user_context();

            foreach ($roleDto->menu_code_list as $key => $menu_code) {
                $roleMenu = new RoleMenu();
                $roleMenu->role_code = $roleDto->code;
                $roleMenu->menu_code = $menu_code;
                $roleMenu->created_by = $userContext->id;
                $roleMenu->saveWithUUid();
            }
        });
    }

    public function update(RoleDto $roleDto): void
    {
        DB::transaction(function () use ($roleDto) {
            RoleMenu::where("role_code", $roleDto->code)->delete();
            $this->save($roleDto);
        });
    }
}
