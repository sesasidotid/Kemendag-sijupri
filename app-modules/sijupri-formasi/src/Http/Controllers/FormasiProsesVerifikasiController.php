<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Dtos\FormasiProsesVerifikasiDto;
use Eyegil\SijupriFormasi\Services\FormasiProsesVerifikasiService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/formasi_proses")]
class FormasiProsesVerifikasiController
{
    public function __construct(
        private FormasiProsesVerifikasiService $formasiProsesVerifikasiService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $formasiProsesVerifikasiSearch = $this->formasiProsesVerifikasiService->findSearch(new Pageable($request->query()));
        return $formasiProsesVerifikasiSearch->setCollection($formasiProsesVerifikasiSearch->getCollection()->map(function ($formasiProsesVerifikasi) {
            $formasiProsesVerifikasiDto = (new FormasiProsesVerifikasiDto())->fromModel($formasiProsesVerifikasi);
            $formasiProsesVerifikasiDto->surat_undangan_url = $this->storageService->getUrl("system", "formasi", $formasiProsesVerifikasiDto->surat_undangan);
            return $formasiProsesVerifikasiDto;
        }));
    }
}
