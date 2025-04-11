<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatPendidikanDto;
use Eyegil\SijupriSiap\Models\RiwayatPendidikan;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RiwayatPendidikanService
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
        return $pageable->with(['pendidikan'])->searchHas(RiwayatPendidikan::class, ['pendidikan']);
    }

    public function findById($id): RiwayatPendidikan
    {
        return RiwayatPendidikan::findOrThrowNotFound($id);
    }

    public function findByNip($nip)
    {
        return RiwayatPendidikan::findMany($nip);
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatPendidikan::where($userContext->id)->latest('tanggal_ijazah')->firstOrThrowNotFound();
    }

    public function save(RiwayatPendidikanDto $riwayatPendidikanDto)
    {
        return DB::transaction(function () use ($riwayatPendidikanDto) {
            $userContext = user_context();
            $riwayatPendidikan = new RiwayatPendidikan();
            $riwayatPendidikan->fromArray($riwayatPendidikanDto->toArray());
            $riwayatPendidikan->created_by = $userContext->id;
            // $riwayatPendidikan->ijazah = "ijazah_" . Carbon::now()->format('YmdHis');
            $riwayatPendidikan->saveWithUUid();

            return $riwayatPendidikan;
        });
    }

    public function update(RiwayatPendidikanDto $riwayatPendidikanDto)
    {
        return DB::transaction(function () use ($riwayatPendidikanDto) {
            $userContext = user_context();
            $riwayatPendidikan = $this->findById($riwayatPendidikanDto->id);
            $riwayatPendidikan->updated_by = $userContext->id;

            if ($riwayatPendidikanDto->ijazah != $riwayatPendidikan->ijazah) {
                $this->storageService->deleteObject("system", "jf", $riwayatPendidikan->ijazah);
            }

            $riwayatPendidikan->fromArray($riwayatPendidikanDto->toArray());
            $riwayatPendidikan->save();

            return $riwayatPendidikan;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatPendidikan = $this->findById($id);

            $riwayatPendidikan["updated_by"] = $userContext->id;
            $riwayatPendidikan["delete_flag"] = true;
            $riwayatPendidikan->save();

            return $riwayatPendidikan;
        });
    }
}
