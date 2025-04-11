<?php

namespace Eyegil\SijupriSiap\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatJabatanDto;
use Eyegil\SijupriSiap\Models\RiwayatJabatan;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class RiwayatJabatanService
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
        return $pageable->with(['jabatan', 'jenjang'])->searchHas(RiwayatJabatan::class, ['jabatan', 'jenjang']);
    }

    public function findById($id): RiwayatJabatan
    {
        return RiwayatJabatan::find($id);
    }

    public function findByNip($nip)
    {
        return RiwayatJabatan::findMany($nip);
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatJabatan::where($userContext->id)->latest('tmt')->firstOrThrowNotFound();
    }

    public function save(RiwayatJabatanDto $riwayatJabatanDto)
    {
        return DB::transaction(function () use ($riwayatJabatanDto) {
            $userContext = user_context();
            $riwayatJabatan = new RiwayatJabatan();
            $riwayatJabatan->created_by = $userContext->id;
            $riwayatJabatan->fromArray($riwayatJabatanDto->toArray());
            $riwayatJabatan->saveWithUUid();

            return $riwayatJabatan;
        });
    }

    public function update(RiwayatJabatanDto $riwayatJabatanDto)
    {
        return DB::transaction(function () use ($riwayatJabatanDto) {
            $userContext = user_context();
            $riwayatJabatan = $this->findById($riwayatJabatanDto->id);

            $riwayatJabatan->updated_by = $userContext->id;

            if ($riwayatJabatanDto->sk_jabatan != $riwayatJabatan->sk_jabatan) {
                $this->storageService->deleteObject("system", "jf", $riwayatJabatan->sk_jabatan);
            }
            $riwayatJabatan->fromArray($riwayatJabatanDto->toArray());
            $riwayatJabatan->save();

            return $riwayatJabatan;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatJabatan = $this->findById($id);

            $riwayatJabatan["updated_by"] = $userContext->id;
            $riwayatJabatan["delete_flag"] = true;
            $riwayatJabatan->save();

            return $riwayatJabatan;
        });
    }
}
