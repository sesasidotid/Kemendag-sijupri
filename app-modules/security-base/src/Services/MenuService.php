<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Converters\MenuConverter;
use Eyegil\SecurityBase\Dtos\MenuDto;
use Eyegil\SecurityBase\Models\Menu;
use Illuminate\Support\Facades\Log;

class MenuService
{
    public function __construct()
    {
    }

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Menu::class);
    }

    public function findAll()
    {
        return Menu::all();
    }

    public function findTree()
    {
        return Menu::with('child')->where("level", 1)
            ->orderBy("idx", "ASC")
            ->orderBy("level", "ASC")
            ->orderBy("code", "ASC")
            ->get();
    }

    public function findTreeByRoleCode($role_code)
    {
        return Menu::with(['child', 'roleMenu'])->where("level", 1)
            ->orderBy("idx", "ASC")
            ->orderBy("level", "ASC")
            ->orderBy("code", "ASC")
            ->get()
            ->map(function (Menu $menu) use ($role_code) {
                $menuDto = MenuConverter::toDto($menu, $role_code);
                $menuDto->child = $menu->child->map(function (Menu $menuChild) use ($role_code) {
                    return MenuConverter::toDto($menuChild, $role_code);
                });

                return $menuDto;
            });
    }

    public function findTreeByRoleCodeAndApplicationCode($role_code, $application_code)
    {
        return Menu::with(['child', 'roleMenu'])->where("application_code", $application_code)
            ->where("level", 1)
            ->orderBy("idx", "ASC")
            ->orderBy("level", "ASC")
            ->orderBy("code", "ASC")
            ->get()
            ->map(function (Menu $menu) use ($role_code) {
                $menuDto = MenuConverter::toDto($menu, $role_code);
                $menuDto->child = $menu->child->map(function (Menu $menuChild) use ($role_code) {
                    return MenuConverter::toDto($menuChild, $role_code);
                });

                return $menuDto;
            });
    }

    public function findAllParent()
    {
        return Menu::where("level", 1)
            ->orderBy("idx", "ASC")
            ->orderBy("level", "ASC")
            ->orderBy("code", "ASC")
            ->get();
    }

    public function findByCode(string $code): Menu
    {
        return Menu::findOrThrowNotFound($code);
    }
}
