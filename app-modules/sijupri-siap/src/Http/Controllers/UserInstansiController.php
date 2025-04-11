<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\UserInstansiDto;
use Eyegil\SijupriSiap\Services\UserInstansiService;
use Illuminate\Http\Request;

#[Controller("/api/v1/user_instansi")]
class UserInstansiController
{
    public function __construct(
        private UserInstansiService $userInstansiService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->userInstansiService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->userInstansiService->findAll();
    }

    #[Get("/{nip}")]
    public function findByNip(Request $request)
    {
        return $this->userInstansiService->findByNip($request->nip);
    }

    #[Post()]
    public function save(Request $request)
    {
        $userInstansiDto = UserInstansiDto::fromRequest($request)->validateSave();
        return $this->userInstansiService->save($userInstansiDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $userInstansiDto = UserInstansiDto::fromRequest($request)->validateUpdate();
        return $this->userInstansiService->update($userInstansiDto);
    }

    #[Delete("/{nip}")]
    public function delete(Request $request)
    {
        return $this->userInstansiService->delete($request->nip);
    }
}
