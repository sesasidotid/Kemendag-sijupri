<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Services\RiwayatPangkatService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_pangkat")]
class RiwayatPangkatController
{
    public function __construct(
        private RiwayatPangkatService $riwayatPangkatService,
        private StorageService $storageService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->riwayatPangkatService->findSearch(new Pageable($request->query()));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwPangkat = $this->riwayatPangkatService->current();
        $result = $rwPangkat->toArray();
        $result['pangkat_name'] = $rwPangkat->pangkat->name;
        $result['sk_pangkat_url'] =  $this->storageService->getUrl("system", "jf", $rwPangkat->sk_pangkat);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwPangkat = $this->riwayatPangkatService->findById($id);
        $result = $rwPangkat->toArray();
        $result['pangkat_name'] = $rwPangkat->pangkat->name;
        $result['sk_pangkat_url'] =  $this->storageService->getUrl("system", "jf", $rwPangkat->sk_pangkat);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatPangkatService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatPangkatService->delete($request->id);
    }
}
