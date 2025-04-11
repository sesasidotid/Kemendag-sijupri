<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Services\RiwayatJabatanService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_jabatan")]
class RiwayatJabatanController
{
    public function __construct(
        private RiwayatJabatanService $riwayatJabatanService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->riwayatJabatanService->findSearch(new Pageable($request->query()));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwJabatan = $this->riwayatJabatanService->current();
        $result = $rwJabatan->toArray();
        $result['jabatan_name'] = $rwJabatan->jabatan->name;
        $result['jenjang_name'] = $rwJabatan->jenjang->name;
        $result['sk_jabatan_url'] =  $this->storageService->getUrl("system", "jf", $rwJabatan->sk_jabatan);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwJabatan = $this->riwayatJabatanService->findById($id);
        $result = $rwJabatan->toArray();
        $result['jabatan_name'] = $rwJabatan->jabatan->name;
        $result['jenjang_name'] = $rwJabatan->jenjang->name;
        $result['sk_jabatan_url'] =  $this->storageService->getUrl("system", "jf", $rwJabatan->sk_jabatan);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatJabatanService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatJabatanService->delete($request->id);
    }
}
