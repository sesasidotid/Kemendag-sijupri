<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KompetensiIndikatorDto;
use Eyegil\SijupriMaintenance\Models\KompetensiIndikator;
use Illuminate\Support\Facades\DB;

class KompetensiIndikatorService
{

    public function __construct(
        private KompetensiService $kompetensiService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual('delete_flag', false);
        $pageable->addEqual('inactive_flag', false);
        return $pageable->search(KompetensiIndikator::class);
    }

    public function findDropList($jabatan_code = null, $jenjang_code = null, $bidang_jabatan_code = null)
    {
        return KompetensiIndikator::query()
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->with('kompetensi')
            ->whereHas('kompetensi', function ($queryKompetensi) use ($jabatan_code, $jenjang_code, $bidang_jabatan_code) {
                $queryKompetensi
                    ->when($jabatan_code, fn($query) => $query->where("jabatan_code", $jabatan_code))
                    ->when($jenjang_code, fn($query) => $query->where("jenjang_code", $jenjang_code))
                    ->when($bidang_jabatan_code, function ($query) use ($bidang_jabatan_code) {
                        $query->where(function ($q) use ($bidang_jabatan_code) {
                            $q->where('bidang_jabatan_code', $bidang_jabatan_code)
                                ->orWhereNull('bidang_jabatan_code');
                        });
                    });
            })
            ->get();
    }

    public function findByCode($code): KompetensiIndikator|null
    {
        return KompetensiIndikator::where('code', $code)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)->first();
    }

    public function findById($id): KompetensiIndikator
    {
        return KompetensiIndikator::findOrThrowNotFound($id);
    }

    public function save(KompetensiIndikatorDto $kompetensiIndikatorDto)
    {
        return DB::transaction(function () use ($kompetensiIndikatorDto) {
            $userContext = user_context();

            $kompetensi = $this->kompetensiService->findById($kompetensiIndikatorDto->kompetensi_id);
            if (!str_starts_with($kompetensiIndikatorDto->code, $kompetensi->code . '-')) {
                $kompetensiIndikatorDto->code = $kompetensi->code . '-' . $kompetensiIndikatorDto->code;
            }

            if ($this->findByCode($kompetensiIndikatorDto->code)) {
                throw new RecordExistException("code already exist", ["code" => $kompetensiIndikatorDto->code]);
            }

            $kompetensiIndikator = new KompetensiIndikator();
            $kompetensiIndikator->created_by = $userContext->id;
            $kompetensiIndikator->fromArray($kompetensiIndikatorDto->toArray());
            $kompetensiIndikator->saveWithUuid();

            return $kompetensiIndikator;
        });
    }

    public function update(KompetensiIndikatorDto $kompetensiIndikatorDto)
    {
        DB::transaction(function () use ($kompetensiIndikatorDto) {
            $userContext = user_context();

            $kompetensiIndikator = $this->findById($kompetensiIndikatorDto->id);
            $kompetensiIndikator->updated_by = $userContext->id;
            $kompetensiIndikator->name = $kompetensiIndikatorDto->name;
            $kompetensiIndikator->save();
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $userContext = user_context();

            $kompetensi = $this->findById($id);
            $kompetensi->updated_by = $userContext->id;
            $kompetensi->delete_flag = true;
            $kompetensi->save();

            return $kompetensi;
        });
    }

    public function deleteByKompetensiId($kompetensi_id)
    {
        DB::transaction(function () use ($kompetensi_id) {
            $userContext = user_context();

            KompetensiIndikator::where("kompetensi_id", $kompetensi_id)->update([
                "updated_by" => $userContext->id,
                "delete_flag" => true,
            ]);
        });
    }
}
