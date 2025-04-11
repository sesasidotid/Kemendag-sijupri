<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\ProvinsiDto;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\Provinsi;
use Illuminate\Support\Facades\DB;

class ProvinsiService
{
    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Provinsi::class);
    }

    public function findAll()
    {
        return Provinsi::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return Provinsi::findOrThrowNotFound($id);
    }

    public function save(ProvinsiDto $provinsiDto)
    {
        return DB::transaction(function () use ($provinsiDto) {
            $userContext = user_context();

            $provinsi = new Provinsi();
            $provinsi->fromArray($provinsiDto->toArray());
            $provinsi->created_by = $userContext->id;
            $provinsi->save();

            $instansi = new Instansi();
            $instansi->name = "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Provinsi " . $provinsi->name;
            $instansi->instansi_type_code = "IT3";
            $instansi->saveWithUUid();

            $instansi = new Instansi();
            $instansi->name = "Badan Kepegawaian Daerah Provinsi " . $provinsi->name;
            $instansi->instansi_type_code = "IT3";
            $instansi->saveWithUUid();

            return $provinsi;
        });
    }

    public function update(ProvinsiDto $provinsiDto)
    {
        return DB::transaction(function () use ($provinsiDto) {
            $userContext = user_context();

            $provinsi = $this->findById($provinsiDto->id);
            $provinsi->fromArray($provinsiDto->toArray());
            $provinsi->updated_by = $userContext->id;
            $provinsi->save();

            return $provinsi;
        });
    }
}
