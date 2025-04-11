<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Services\RiwayatPendidikanService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_pendidikan")]
class RiwayatPendidikanController
{
    public function __construct(
        private RiwayatPendidikanService $riwayatPendidikanService,
        private StorageService $storageService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->riwayatPendidikanService->findSearch(new Pageable($request->query()));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwPendidikan = $this->riwayatPendidikanService->current();
        $result = $rwPendidikan->toArray();
        $result['pendidikan_name'] = $rwPendidikan->pendidikan->name;
        $result['ijazahUrl'] =  $this->storageService->getUrl("system", "jf", $rwPendidikan->ijazah);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwPendidikan = $this->riwayatPendidikanService->findById($id);
        $result = $rwPendidikan->toArray();
        $result['pendidikan_name'] = $rwPendidikan->pendidikan->name;
        $result['ijazahUrl'] =  $this->storageService->getUrl("system", "jf", $rwPendidikan->ijazah);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatPendidikanService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatPendidikanService->delete($request->id);
    }
}
