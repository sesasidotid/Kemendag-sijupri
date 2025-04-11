<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Models\RiwayatKinerja;
use Eyegil\SijupriSiap\Services\RiwayatKinerjaService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_kinerja")]
class RiwayatKinerjaController
{
    public function __construct(
        private RiwayatKinerjaService $riwayatKinerjaService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $search = $this->riwayatKinerjaService->findSearch(new Pageable($request->query()));
        return $search->setCollection($search->getCollection()->map(function (RiwayatKinerja $riwayatKinerja) {
            $rwKinerjaDto = $riwayatKinerja->toArray();
            $rwKinerjaDto['predikat_kinerja_value'] = $riwayatKinerja->predikatKinerja->value;
            $rwKinerjaDto['rating_hasil_value'] = $riwayatKinerja->ratingHasil->value;
            $rwKinerjaDto['rating_kinerja_value'] = $riwayatKinerja->ratingKinerja->value;

            return $rwKinerjaDto;
        }));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwKinerja = $this->riwayatKinerjaService->current();
        $result = $rwKinerja->toArray();
        $result['rating_hasil_name'] = $rwKinerja->ratingHasil->name;
        $result['rating_kinerja_name'] = $rwKinerja->ratingKinerja->name;
        $result['predikat_kinerja_name'] = $rwKinerja->predikatKinerja->name;
        $result['doc_evaluasi_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_evaluasi);
        $result['doc_predikat_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_predikat);
        $result['doc_akumulasi_ak_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_akumulasi_ak);
        $result['doc_penetapan_ak_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_penetapan_ak);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwKinerja = $this->riwayatKinerjaService->findById($id);
        $result = $rwKinerja->toArray();
        $result['rating_hasil_name'] = optional($rwKinerja->ratingHasil)->name;
        $result['rating_kinerja_name'] = optional($rwKinerja->ratingKinerja)->name;
        $result['predikat_kinerja_name'] = optional($rwKinerja->predikatKinerja)->name;
        $result['doc_evaluasi_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_evaluasi);
        $result['doc_predikat_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_predikat);
        $result['doc_akumulasi_ak_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_akumulasi_ak);
        $result['doc_penetapan_ak_url'] =  $this->storageService->getUrl("system", "jf", $rwKinerja->doc_penetapan_ak);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatKinerjaService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatKinerjaService->delete($request->id);
    }
}
