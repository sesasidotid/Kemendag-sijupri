<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\MenuService;
use Illuminate\Http\Request;

#[Controller("/api/v1/menu")]
class MenuController
{

    public function __construct(
        private MenuService $menuService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->menuService->findAll();
    }

    #[Get("/tree")]
    public function findTree()
    {
        return $this->menuService->findTree();
    }

    #[Get("/tree/{role_code}")]
    public function findTreeByRoleCode(Request $request)
    {
        return $this->menuService->findTreeByRoleCode($request->role_code);
    }

    #[Get("/tree/{role_code}/{application_code}")]
    public function findTreeByRoleCodeAndApplicationCode(Request $request)
    {
        return $this->menuService->findTreeByRoleCodeAndApplicationCode($request->role_code, $request->application_code);
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->menuService->findSearch(new Pageable($request->query()));
    }

    #[Get("/{code}")]
    public function findByCode(Request $request)
    {
        return $this->menuService->findByCode($request->code);
    }
}
