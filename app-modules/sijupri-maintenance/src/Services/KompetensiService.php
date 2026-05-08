<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KompetensiDto;
use Eyegil\SijupriMaintenance\Models\Kompetensi;
use Eyegil\SijupriMaintenance\Models\KompetensiIndikator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KompetensiService
{
    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual('delete_flag', false);
        $pageable->addEqual('inactive_flag', false);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Kompetensi::class);
    }

    public function findById($id): Kompetensi
    {
        return Kompetensi::findOrThrowNotFound($id);
    }

    public function findDropList($jabatan_code = null, $jenjang_code = null, $bidang_jabatan_code = null)
    {
        return Kompetensi::query()
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->when($jabatan_code, fn($query) => $query->where("jabatan_code", $jabatan_code))
            ->when($jenjang_code, fn($query) => $query->where("jenjang_code", $jenjang_code))
            ->when($bidang_jabatan_code, function ($query) use ($bidang_jabatan_code) {
                $query->where(function ($q) use ($bidang_jabatan_code) {
                    $q->where("bidang_jabatan_code", $bidang_jabatan_code)
                        ->orWhereNull("bidang_jabatan_code");
                });
            })
            ->get();
    }

    public function findByCode($code): Kompetensi|null
    {
        return Kompetensi::where('code', $code)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)->first();
    }

    public function save(KompetensiDto $kompetensiDto)
    {
        DB::transaction(function () use ($kompetensiDto) {
            $userContext = user_context();

            if ($this->findByCode($kompetensiDto->code)) {
                throw new RecordExistException("code already exist", ["code" => $kompetensiDto->code]);
            }

            $kompetensi = new Kompetensi();
            $kompetensi->fromArray($kompetensiDto->toArray());
            $kompetensi->created_by = $userContext->id;
            $kompetensi->saveWithUuid();
        });
    }

    public function update(KompetensiDto $kompetensiDto)
    {
        DB::transaction(function () use ($kompetensiDto) {
            $userContext = user_context();

            $kompetensi = $this->findById($kompetensiDto->id);
            $kompetensi->updated_by = $userContext->id;
            $kompetensi->name = $kompetensiDto->name;
            $kompetensi->description = $kompetensiDto->description;
            $kompetensi->level = $kompetensiDto->level;
            $kompetensi->save();
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

            KompetensiIndikator::where("kompetensi_id", $kompetensi->id)->update([
                "updated_by" => $userContext->id,
                "delete_flag" => true,
            ]);

            return $kompetensi;
        });
    }
}
