<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\UserUnitKerjaDto;
use Eyegil\SijupriSiap\Services\UserUnitKerjaService;
use Illuminate\Http\Request;

#[Controller("/api/v1/user_unit_kerja")]
class UserUnitKerjaController
{
    public function __construct(
        private UserUnitKerjaService $userUnitKerjaService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->userUnitKerjaService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->userUnitKerjaService->findAll();
    }

    #[Get("/{nip}")]
    public function findByNip($nip)
    {
        return $this->userUnitKerjaService->findByNip($nip);
    }

    #[Post()]
    public function save(Request $request)
    {
        $userUnitKerjaDto = UserUnitKerjaDto::fromRequest($request)->validateSave();
        return $this->userUnitKerjaService->save($userUnitKerjaDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $userUnitKerjaDto = UserUnitKerjaDto::fromRequest($request)->validateUpdate();
        return $this->userUnitKerjaService->update($userUnitKerjaDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->userUnitKerjaService->delete($request->id);
    }
}
