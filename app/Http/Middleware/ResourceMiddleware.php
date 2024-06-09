<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessException;
use App\Models\Security\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use stdClass;
use Illuminate\Database\Eloquent\Builder;

class ResourceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();
        $routeName = "/" . ($route ? $route->uri() : "");
        if (!$routeName) {
            throw new BusinessException("Menu not found", 500);
        }

        $userContext = auth()->user();
        $accessData = $this->getMenuList($userContext);

        if (!$this->isAuthorized($accessData->routeList, $routeName)) {
            throw new BusinessException([
                "message" => "Not authorized " . $routeName,
                "error code" => "AUTH-000001",
                "code" => 500
            ], 500);
        }

        view()->share('menuList', $accessData->menuList);
        return $next($request);
    }

    private function getMenuList($userContext)
    {
        return Cache::remember('menu_data_' . $userContext->nip, 60, function () use ($userContext) {
            $menuList = Menu::whereHas('roleMenu', function (Builder $query) use ($userContext) {
                $query->where('role_code', $userContext->role_code);
            })->where('lvl', 0)->where('delete_flag', false)->where('inactive_flag', false)->orderBy('idx', 'ASC')->get();

            $accessList = new stdClass();
            $accessList->menuList = [];
            $accessList->routeList = [];
            foreach ($menuList as $key => $menu) {
                $tempMenu = new stdClass();
                $tempMenu->code = $menu->code;
                $tempMenu->name = $menu->name;
                $tempMenu->url = strtolower("/" . str_replace("/", "_", str_replace(" ", "_", $menu->name)));
                $tempMenu->child = [];

                $accessList->menuList[$menu->code] = $tempMenu;
                $accessList->routeList = array_merge($accessList->routeList, explode(',', $menu->routes));

                $children = $menu->existingChild;
                if ($children && count($children) > 0) {
                    foreach ($children as $key => $child) {
                        $tempMenu = new stdClass();
                        $tempMenu->code = $child->code;
                        $tempMenu->name = $child->name;
                        $tempMenu->url = strtolower($accessList->menuList[$menu->code]->url . "/" . str_replace("/", "_", str_replace(" ", "_", $child->name)));

                        $accessList->menuList[$menu->code]->child[$child->code] = $tempMenu;
                        $accessList->routeList = array_merge($accessList->routeList, explode(',', $child->routes));
                    }
                }
            }

            return $accessList;
        });
    }

    private function isAuthorized($routeList, $path)
    {
        foreach ($routeList as $pattern) {
            if ($this->pathMatchesPattern($pattern, $path)) {
                return true;
            }
        }
        return false;
    }

    private function pathMatchesPattern($pattern, $path)
    {
        $patternSegments = explode('/', trim($pattern, '/'));
        $routeSegments = explode('/', trim($path, '/'));

        foreach ($patternSegments as $key => $segment) {
            if ($segment === '**') {
                return true;
            }
            if (!isset($routeSegments[$key]) || $routeSegments[$key] !== $segment) {
                return false;
            }
        }
        return true;
    }

    // private function isAuthorized($routeList, $routeName)
    // {
    //     foreach ($routeList as $pattern) {
    //         if ($this->routeMatchesPattern($pattern, $routeName)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    private function routeMatchesPattern($pattern, $routeName)
    {
        $pattern = str_replace('.', '\\.', $pattern);
        $pattern = str_replace('*', '.*', $pattern);
        $pattern = str_replace('**', '.*', $pattern);
        $pattern = '/^' . $pattern . '$/';

        return (bool) preg_match($pattern, $routeName);
    }
}
