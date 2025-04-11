<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Dtos\RoleDto;
use Eyegil\SecurityBase\Services\RoleService;
use Illuminate\Http\Request;

#[Controller("/api/v1/role")]
class RoleController
{

    public function __construct(
        private RoleService $roleService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->roleService->findAll();
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->roleService->findSearch(new Pageable($request->query()));
    }

    #[Get("/{code}")]
    public function findByCode(Request $request)
    {
        return $this->roleService->findByCode($request->code);
    }

    #[Get("/application/{application_code}")]
    public function findByApplicationCode(Request $request)
    {
        return $this->roleService->findByApplicationCode($request->application_code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $roleDto = RoleDto::fromRequest($request)->validateSave();
        return $this->roleService->save($roleDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $roleDto = RoleDto::fromRequest($request)->validateUpdate();
        return $this->roleService->update($roleDto);
    }

    #[Delete("/{code}")]
    public function delete(Request $request)
    {
        return $this->roleService->delete($request->code);
    }
}
