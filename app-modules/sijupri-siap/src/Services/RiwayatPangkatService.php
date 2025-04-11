<?php

namespace Eyegil\SijupriSiap\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Dtos\RiwayatPangkatDto;
use Eyegil\SijupriSiap\Models\RiwayatPangkat;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class RiwayatPangkatService
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
        return $pageable->with(['pangkat'])->searchHas(RiwayatPangkat::class, ['pangkat']);
    }

    public function findById($id): RiwayatPangkat
    {
        return RiwayatPangkat::find($id);
    }

    public function findByNip($nip)
    {
        return RiwayatPangkat::findMany($nip);
    }

    public function current()
    {
        $userContext = user_context();
        return RiwayatPangkat::where($userContext->id)->latest('tmt')->firstOrThrowNotFound();
    }

    public function save(RiwayatPangkatDto $riwayatPangkatDto)
    {
        return DB::transaction(function () use ($riwayatPangkatDto) {
            $userContext = user_context();
            $riwayatPangkat = new RiwayatPangkat();
            $riwayatPangkat->created_by = $userContext->id;
            $riwayatPangkat->fromArray($riwayatPangkatDto->toArray());
            $riwayatPangkat->saveWithUUid();

            return $riwayatPangkat;
        });
    }

    public function update(RiwayatPangkatDto $riwayatPangkatDto)
    {
        return DB::transaction(function () use ($riwayatPangkatDto) {
            $userContext = user_context();
            $riwayatPangkat = $this->findById($riwayatPangkatDto->id);

            $riwayatPangkat->updated_by = $userContext->id;

            if ($riwayatPangkatDto->sk_pangkat != $riwayatPangkat->sk_pangkat) {
                $this->storageService->deleteObject("system", "jf", $riwayatPangkat->sk_pangkat);
            }
            $riwayatPangkat->fromArray($riwayatPangkatDto->toArray());
            $riwayatPangkat->save();

            return $riwayatPangkat;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $riwayatPangkat = $this->findById($id);

            $riwayatPangkat["updated_by"] = $userContext->id;
            $riwayatPangkat["delete_flag"] = true;
            $riwayatPangkat->save();

            return $riwayatPangkat;
        });
    }
}
