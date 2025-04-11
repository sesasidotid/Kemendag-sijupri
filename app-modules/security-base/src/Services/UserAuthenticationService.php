<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityBase\Dtos\MenuDto;
use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\LoginContext;
use Eyegil\SecurityBase\Models\ApplicationChannel;
use Eyegil\SecurityBase\Models\UserApplicationChannel;
use Illuminate\Support\Facades\DB;

class UserAuthenticationService
{
    private string $default_authentication_type;
    public function __construct(
        private UserService $userService,
        private MenuService $menuService,
        private UserRoleService $userRoleService,
        private RoleMenuService $roleMenuService,
        private AuthenticationServiceMap $authenticationServiceMap
    ) {
        $this->default_authentication_type = config('eyegil.security.defaultAuthType');
    }

    public function register(UserDto $userDto, $options = null)
    {
        $applicationChannel = ApplicationChannel::where("application_code", $userDto->application_code)->first();
        if ($applicationChannel) {
            $authentication_type = $applicationChannel->auth_type;
        } else {
            $authentication_type = $this->default_authentication_type;
        }

        DB::transaction(function () use ($authentication_type, $userDto, $options) {
            $this->userService->save($userDto);
            $this->authenticationServiceMap->get($authentication_type)->register($userDto->id, $userDto->password, $options);
        });
    }

    public function update(userDto $userDto)
    {
        $this->userService->update($userDto);
    }

    public function delete($id)
    {
        return $this->userService->delete($id);
    }

    public function login($user_id, $password_, $application_code, $authentication_type = null, $options = null): LoginContext
    {
        $auth_type = $authentication_type ?? $this->default_authentication_type;

        $user = $this->userService->findById($user_id);
        if (!UserApplicationChannel::where('user_id', $user_id)->where('application_code', $application_code)->first()) {
            throw new BusinessException("not authorized for authentication", "");
        }
        $loginContext = $this->authenticationServiceMap->get($auth_type)->login($user_id, $password_, $options);

        $loginContext->user_id = $user->id;
        $loginContext->name = $user->name;
        $loginContext->email = $user->email;
        $loginContext->menu_codes = [];
        $loginContext->role_codes = [];
        $loginContext->menus = [];

        $roles = [];
        $userRoleList = $this->userRoleService->findByUserId($user_id);
        foreach ($userRoleList as $key => $userRole) {
            array_push($loginContext->role_codes, $userRole->role_code);
            $roles[$userRole->role_code] = $userRole->role;
        }

        $menuRpr = [];
        $roleMenuList = $this->roleMenuService->findByRoleCodeList($loginContext->role_codes);
        foreach ($roleMenuList as $key => $roleMenu) {
            if (isset($menuRpr[$roleMenu->menu_code])) {
                $menuRpr[$roleMenu->menu_code]['is_creatable'] = $menuRpr[$roleMenu->menu_code]['is_creatable'] ? $menuRpr[$roleMenu->menu_code]['is_creatable'] : $roles[$roleMenu->roleCode]['is_creatable'];
                $menuRpr[$roleMenu->menu_code]['is_updatable'] = $menuRpr[$roleMenu->menu_code]['is_updatable'] ? $menuRpr[$roleMenu->menu_code]['is_updatable'] : $roles[$roleMenu->roleCode]['is_updatable'];
                $menuRpr[$roleMenu->menu_code]['is_deletable'] = $menuRpr[$roleMenu->menu_code]['is_deletable'] ? $menuRpr[$roleMenu->menu_code]['is_deletable'] : $roles[$roleMenu->roleCode]['is_deletable'];
            } else {
                $menuRpr[$roleMenu->menu_code] = [
                    "is_creatable" => $roles[$roleMenu->role_code]->creatable,
                    "is_updatable" => $roles[$roleMenu->role_code]->updatable,
                    "is_deletable" => $roles[$roleMenu->role_code]->deletable,
                ];
                array_push($loginContext->menu_codes, $roleMenu->menu_code);
            }
        }

        $menuList = $this->menuService->findAllParent();
        $menus = [];
        $urls = [];
        if ($menuList && $menuRpr && $loginContext->menu_codes) {
            $this->toMenuTree($menuList, $menus, $urls, $menuRpr, $loginContext->menu_codes);
            $loginContext->menus = $menus;
            $loginContext->urls = $this->mergeUrlsCombinations($urls);
        }

        return $loginContext;
    }

    public function refreshLogin($user_id, $application_code, $options = null): LoginContext
    {
        $auth_type = $authentication_type ?? $this->default_authentication_type;

        $user = $this->userService->findById($user_id);
        if (!UserApplicationChannel::where('user_id', $user_id)->where('application_code', $application_code)->first()) {
            throw new BusinessException("not authorized for authentication", "");
        }
        $loginContext = new LoginContext();

        $loginContext->user_id = $user->id;
        $loginContext->name = $user->name;
        $loginContext->email = $user->email;
        $loginContext->menu_codes = [];
        $loginContext->role_codes = [];
        $loginContext->menus = [];

        $roles = [];
        $userRoleList = $this->userRoleService->findByUserId($user_id);
        foreach ($userRoleList as $key => $userRole) {
            array_push($loginContext->role_codes, $userRole->role_code);
            $roles[$userRole->role_code] = $userRole->role;
        }

        $menuRpr = [];
        $roleMenuList = $this->roleMenuService->findByRoleCodeList($loginContext->role_codes);
        foreach ($roleMenuList as $key => $roleMenu) {
            if (isset($menuRpr[$roleMenu->menu_code])) {
                $menuRpr[$roleMenu->menu_code]['is_creatable'] = $menuRpr[$roleMenu->menu_code]['is_creatable'] ? $menuRpr[$roleMenu->menu_code]['is_creatable'] : $roles[$roleMenu->roleCode]['is_creatable'];
                $menuRpr[$roleMenu->menu_code]['is_updatable'] = $menuRpr[$roleMenu->menu_code]['is_updatable'] ? $menuRpr[$roleMenu->menu_code]['is_updatable'] : $roles[$roleMenu->roleCode]['is_updatable'];
                $menuRpr[$roleMenu->menu_code]['is_deletable'] = $menuRpr[$roleMenu->menu_code]['is_deletable'] ? $menuRpr[$roleMenu->menu_code]['is_deletable'] : $roles[$roleMenu->roleCode]['is_deletable'];
            } else {
                $menuRpr[$roleMenu->menu_code] = [
                    "is_creatable" => $roles[$roleMenu->role_code]->creatable,
                    "is_updatable" => $roles[$roleMenu->role_code]->updatable,
                    "is_deletable" => $roles[$roleMenu->role_code]->deletable,
                ];
                array_push($loginContext->menu_codes, $roleMenu->menu_code);
            }
        }

        $menuList = $this->menuService->findAllParent();
        $menus = [];
        $urls = [];
        if ($menuList && $menuRpr && $loginContext->menu_codes) {
            $this->toMenuTree($menuList, $menus, $urls, $menuRpr, $loginContext->menu_codes);
            $loginContext->menus = $menus;
            $loginContext->urls = $this->mergeUrlsCombinations($urls);
        }

        return $loginContext;
    }

    private function mergeUrlsCombinations($input)
    {
        $urlMap = [];

        foreach ($input as $key => $value) {
            $seperation =  explode("|", $value);
            $url = $seperation[0];
            $combination = $seperation[1];

            if (!in_array($url, $urlMap)) {
                $urlMap[$url] = '';
            }

            $existingCombination = $urlMap[$url];
            foreach (str_split($combination) as $char) {
                if (!str_contains($existingCombination, $char)) {
                    $existingCombination = $existingCombination . $char;
                }
            }

            $urlMap[$url] = $existingCombination;
        }

        $result = [];
        foreach ($urlMap as $url => $combination) {
            $result[] = $url . '|' . $combination;
        }

        return $result;
    }

    private function toMenuTree($menuList, array &$menus, &$urls, $menuRpr, $allowedMenu)
    {
        foreach ($menuList as $key => $menu) {
            $child = $menu->child;
            $urlsTemp = explode(",", trim($menu->url));
            if (isset($menuRpr[$menu->code])) {
                $menuDto = new MenuDto();
                $menuDto->fromArray($menu->toArray());
                $menuDto->is_creatable = $menuRpr[$menu->code]['is_creatable'];
                $menuDto->is_updatable = $menuRpr[$menu->code]['is_updatable'];
                $menuDto->is_deletable = $menuRpr[$menu->code]['is_deletable'];
                if ($child) {
                    $menuDto->child = [];
                    $this->toMenuTree($child, $menuDto->child, $urls, $menuRpr, $allowedMenu);
                }
                foreach ($urlsTemp as $key => $url) {
                    array_push($urls, $url . '|' . ($menuDto->is_creatable ? 'C' : '') . ($menuDto->is_updatable ? 'U' : '') . ($menuDto->is_deletable ? 'D' : ''));
                }
                array_push($menus, $menuDto);
            }
        }
    }
}
