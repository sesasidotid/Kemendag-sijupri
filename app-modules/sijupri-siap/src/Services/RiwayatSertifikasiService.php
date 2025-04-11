<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatSertifikasiDto;
use Eyegil\SijupriSiap\Models\RiwayatSertifikasi;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class RiwayatSertifikasiService
{
    public function __construct(
        private StorageService $storageService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if ($userContext->application_code == "sijupri-internal" || $userContext->application_code == "sijupri-external") {
            $pageable->addEqual("nip", $userContext->id);
        }
        return $pageable->with(['jf'])->search(RiwayatSertifikasi::class);
    }

    public function findById($id): RiwayatSertifikasi
    {
        return RiwayatSertifikasi::find($id);
    }

    public function findByNip($nip)
    {
        return RiwayatSertifikasi::findMany($nip);
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatSertifikasi::where($userContext->id)->latest('date_end')->firstOrThrowNotFound();
    }

    public function save(RiwayatSertifikasiDto $riwayatSertifikasiDto)
    {
        return DB::transaction(function () use ($riwayatSertifikasiDto) {
            $userContext = user_context();
            $riwayatSertifikasi = new RiwayatSertifikasi();
            $riwayatSertifikasi->created_by = $userContext->id;
            $riwayatSertifikasi->fromArray($riwayatSertifikasiDto->toArray());
            $riwayatSertifikasi->saveWithUUid();

            return $riwayatSertifikasi;
        });
    }

    public function update(RiwayatSertifikasiDto $riwayatSertifikasiDto)
    {
        return DB::transaction(function () use ($riwayatSertifikasiDto) {
            $userContext = user_context();
            $riwayatSertifikasi = $this->findById($riwayatSertifikasiDto->id);

            $riwayatSertifikasi->updated_by = $userContext->id;

            if ($riwayatSertifikasiDto->sk_pengangkatan != $riwayatSertifikasi->sk_pengangkatan) {
                $this->storageService->deleteObject("system", "jf", $riwayatSertifikasi->sk_pengangkatan);
            }
            if ($riwayatSertifikasiDto->ktp_ppns != $riwayatSertifikasi->ktp_ppns) {
                $this->storageService->deleteObject("system", "jf", $riwayatSertifikasi->ktp_ppns);
            }

            $riwayatSertifikasi->fromArray($riwayatSertifikasiDto->toArray());
            $riwayatSertifikasi->save();

            return $riwayatSertifikasi;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatSertifikasi = $this->findById($id);

            $riwayatSertifikasi["updated_by"] = $userContext->id;
            $riwayatSertifikasi["delete_flag"] = true;
            $riwayatSertifikasi->save();

            return $riwayatSertifikasi;
        });
    }
}
