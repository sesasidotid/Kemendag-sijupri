<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriMaintenance\Dtos\DokumenPersyaratanDto;
use Eyegil\SijupriMaintenance\Services\DokumenPersyaratanService;
use Illuminate\Http\Request;

#[Controller("/api/v1/doc_persyaratan")]
class DokumenPersyaratanController
{
    public function __construct(
        private DokumenPersyaratanService $dokumenPersyaratanService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->dokumenPersyaratanService->findAll();
    }

    #[Get("/association/{association}")]
    public function findByAssociation($association)
    {
        return $this->dokumenPersyaratanService->findByAssociation($association);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->dokumenPersyaratanService->findById($id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $dokumenPersyaratanDto = DokumenPersyaratanDto::fromRequest($request)->validateSave();
        return $this->dokumenPersyaratanService->save($dokumenPersyaratanDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->dokumenPersyaratanService->delete($request->id);
    }
}
