<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatKompetensiDto;
use Eyegil\SijupriSiap\Models\RiwayatKompetensi;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class RiwayatKompetensiService
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
        return $pageable->with(['jf'])->search(RiwayatKompetensi::class);
    }

    public function findById($id): RiwayatKompetensi
    {
        return RiwayatKompetensi::find($id);
    }

    public function findByNip($nip)
    {
        return RiwayatKompetensi::findMany($nip);
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatKompetensi::where($userContext->id)->latest('tgl_sertifikat')->firstOrThrowNotFound();
    }

    public function save(RiwayatKompetensiDto $riwayatKompetensiDto)
    {
        return DB::transaction(function () use ($riwayatKompetensiDto) {
            $userContext = user_context();
            $riwayatKompetensi = new RiwayatKompetensi();
            $riwayatKompetensi->created_by = $userContext->id;
            $riwayatKompetensi->fromArray($riwayatKompetensiDto->toArray());
            $riwayatKompetensi->saveWithUUid();

            return $riwayatKompetensi;
        });
    }

    public function update(RiwayatKompetensiDto $riwayatKompetensiDto)
    {
        return DB::transaction(function () use ($riwayatKompetensiDto) {
            $userContext = user_context();
            $riwayatKompetensi = $this->findById($riwayatKompetensiDto->id);

            $riwayatKompetensi->updated_by = $userContext->id;

            if ($riwayatKompetensiDto->sertifikat != $riwayatKompetensi->sertifikat) {
                $this->storageService->deleteObject("system", "jf", $riwayatKompetensi->sertifikat);
            }

            $riwayatKompetensi->fromArray($riwayatKompetensiDto->toArray());
            $riwayatKompetensi->save();

            return $riwayatKompetensi;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatKompetensi = $this->findById($id);

            $riwayatKompetensi["updated_by"] = $userContext->id;
            $riwayatKompetensi["delete_flag"] = true;
            $riwayatKompetensi->save();

            return $riwayatKompetensi;
        });
    }
}
