<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Services\RiwayatSertifikasiService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/rw_sertifikasi")]
class RiwayatSertifikasiController
{
    public function __construct(
        private RiwayatSertifikasiService $riwayatSertifikasiService,
        private StorageService $storageService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->riwayatSertifikasiService->findSearch(new Pageable($request->query()));
    }

    #[Get("/current")]
    public function getCurrent()
    {
        $rwSertifikasi =  $this->riwayatSertifikasiService->current();
        $result = $rwSertifikasi->toArray();
        $result['kategori_sertifikasi_name'] = $rwSertifikasi->kategoriSertifikasi->name;
        $result['kategori_sertifikasi_value'] = $rwSertifikasi->kategoriSertifikasi->value;
        if ($rwSertifikasi->ktp_ppns)
            $result['ktp_ppns_url'] =  $this->storageService->getUrl("system", "jf", $rwSertifikasi->ktp_ppns);
        $result['sk_pengangkatan_url'] =  $this->storageService->getUrl("system", "jf", $rwSertifikasi->sk_pengangkatan);
        return $result;
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $rwSertifikasi = $this->riwayatSertifikasiService->findById($id);
        $result = $rwSertifikasi->toArray();
        $result['kategori_sertifikasi_name'] = $rwSertifikasi->kategoriSertifikasi->name;
        $result['kategori_sertifikasi_value'] = $rwSertifikasi->kategoriSertifikasi->value;
        if ($rwSertifikasi->ktp_ppns)
            $result['ktp_ppns_url'] =  $this->storageService->getUrl("system", "jf", $rwSertifikasi->ktp_ppns);
        $result['sk_pengangkatan_url'] =  $this->storageService->getUrl("system", "jf", $rwSertifikasi->sk_pengangkatan);
        return $result;
    }

    #[Get("/jf/{nip}")]
    public function findByNip($nip)
    {
        return $this->riwayatSertifikasiService->findByNip($nip);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->riwayatSertifikasiService->delete($request->id);
    }
}
