<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\KabupatenKotaDto;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\KabupatenKota;
use Illuminate\Support\Facades\DB;

class KabupatenKotaService
{
    public function findSearch(Pageable $pageable)
    {
        return $pageable->with(['provinsi'])->searchHas(KabupatenKota::class, ['provinsi']);
    }

    public function findAll()
    {
        return KabupatenKota::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findAllKota()
    {
        return KabupatenKota::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('type', "KOTA")
            ->get();
    }

    public function findAllKabupaten()
    {
        return KabupatenKota::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('type', "KABUPATEN")
            ->get();
    }

    public function findById($id)
    {
        return KabupatenKota::findOrThrowNotFound($id);
    }

    public function findByTypeAndProvinsiId($type, $provinsi_id)
    {
        return KabupatenKota::where('type', $type)
            ->where('provinsi_id', $provinsi_id)
            ->get();
    }

    public function save(KabupatenKotaDto $kabupatenKotaDto)
    {
        return DB::transaction(function () use ($kabupatenKotaDto) {
            $userContext = user_context();

            $kabupatenKota = new KabupatenKota();
            $kabupatenKota->fromArray($kabupatenKotaDto->toArray());
            $kabupatenKota->created_by = $userContext->id;
            $kabupatenKota->save();

            $instansi = new Instansi();
            $instansi->name = "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia " . ucwords(strtolower($kabupatenKota->type)) . " " . ucwords(strtolower($kabupatenKota->name));
            $instansi->instansi_type_code = $kabupatenKota->type == "KABUPATEN" ? "IT4" : "IT5";
            $instansi->saveWithUUid();

            $instansi = new Instansi();
            $instansi->name = "Badan Kepegawaian Daerah " . ucwords(strtolower($kabupatenKota->type)) . " " . ucwords(strtolower($kabupatenKota->name));
            $instansi->instansi_type_code = $kabupatenKota->type == "KABUPATEN" ? "IT4" : "IT5";
            $instansi->saveWithUUid();

            return $kabupatenKota;
        });
    }

    public function update(KabupatenKotaDto $kabupatenKotaDto)
    {
        return DB::transaction(function () use ($kabupatenKotaDto) {
            $userContext = user_context();

            $kabupatenKota = $this->findById($kabupatenKotaDto->id);
            $kabupatenKota->fromArray($kabupatenKotaDto->toArray());
            $kabupatenKota->updated_by = $userContext->id;
            $kabupatenKota->save();

            return $kabupatenKota;
        });
    }
}
