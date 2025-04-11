<?php

namespace Eyegil\SecurityBase\Converters;

use Eyegil\SecurityBase\Dtos\MenuDto;
use Eyegil\SecurityBase\Models\Menu;
use Illuminate\Support\Facades\Log;

class MenuConverter
{
    public static function toDto(Menu $menu, $role_code = null): MenuDto
    {
        $menuDto = new MenuDto();
        $menuDto->code = $menu->code;
        $menuDto->parent_menu_code = $menu->parent_menu_code;
        $menuDto->application_code = $menu->application_code;
        $menuDto->name = $menu->name;
        $menuDto->description = $menu->description;

        if ($role_code && $menu->roleMenu) {
            foreach ($menu->roleMenu as $key => $roleMenu) {
                $menuDto->checked = $roleMenu->role_code == $role_code ? true : false;
            }
        }
        return $menuDto;
    }
}
