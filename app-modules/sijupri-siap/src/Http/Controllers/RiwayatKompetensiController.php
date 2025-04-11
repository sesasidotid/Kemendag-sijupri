<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Services\RiwayatKompetensiService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_kompetensi")]
class RiwayatKompetensiController
{
    public function __construct(
        private RiwayatKompetensiService $riwayatKompetensiService,
        private StorageService $storageService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->riwayatKompetensiService->findSearch(new Pageable($request->query()));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwKompetensi = $this->riwayatKompetensiService->current();
        $result = $rwKompetensi->toArray();
        $result['kategori_pengembangan_name'] = $rwKompetensi->kategoriPengembangan->name;
        $result['sertifikat_url'] =  $this->storageService->getUrl("system", "jf", $rwKompetensi->sertifikat);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwKompetensi = $this->riwayatKompetensiService->findById($id);
        $result = $rwKompetensi->toArray();
        $result['kategori_pengembangan_name'] = $rwKompetensi->kategoriPengembangan->name;
        $result['sertifikat_url'] =  $this->storageService->getUrl("system", "jf", $rwKompetensi->sertifikat);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatKompetensiService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatKompetensiService->delete($request->id);
    }
}
