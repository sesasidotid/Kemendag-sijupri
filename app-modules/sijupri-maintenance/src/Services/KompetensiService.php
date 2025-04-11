<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KompetensiDto;
use Eyegil\SijupriMaintenance\Models\Kompetensi;
use Illuminate\Support\Facades\DB;

class KompetensiService
{
    public function findSearch(Pageable $pageable)
    {
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
            ->when($jabatan_code, fn($query) => $query->where("jabatan_code", $jabatan_code))
            ->when($jenjang_code, fn($query) => $query->where("jenjang_code", $jenjang_code))
            ->when($bidang_jabatan_code, fn($query) => $query->where("bidang_jabatan_code", $bidang_jabatan_code))
            ->get();
    }

    public function findByCode($code): Kompetensi|null
    {
        return Kompetensi::where('code', $code)->first();
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
            $kompetensi->created_by = $userContext->id;
            $kompetensi->name = $kompetensiDto->name;
            $kompetensi->description = $kompetensiDto->description;
            $kompetensi->saveWithUuid();
        });
    }
}
