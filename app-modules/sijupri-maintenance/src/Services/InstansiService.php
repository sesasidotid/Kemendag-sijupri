<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Models\Instansi;
use Illuminate\Support\Facades\DB;

class InstansiService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(Instansi::class);
    }

    public function findAll()
    {
        return Instansi::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return Instansi::findOrThrowNotFound($id);
    }

    public function findByInstansiTypeCode($instansi_type_code)
    {
        return Instansi::where('instansi_type_code', $instansi_type_code)->get();
    }

    public function findByProvinsiId($provinsi_id)
    {
        return Instansi::where('provinsi_id', $provinsi_id)->get();
    }

    public function findByKabupatenKotaiId($kabupaten_kota_id)
    {
        return Instansi::orWhere('kabupaten_id', $kabupaten_kota_id)->orWhere('kota_id', $kabupaten_kota_id)->get();
    }

    public function save(array $instansiDto)
    {
        return DB::transaction(function () use ($instansiDto) {
            $userContext = user_context();
            $instansiDto['created_by'] = $userContext->id;
            return Instansi::createWithUuid($instansiDto);
        });
    }

    public function update(array $instansiDto)
    {
        return DB::transaction(function () use ($instansiDto) {
            $userContext = user_context();
            $instansi = $this->findById($instansiDto['id']);

            $instansiDto['updated_by'] = $userContext->id;;
            $instansi->fromArray($instansiDto);
            $instansi->save();

            return $instansi;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $instansi = $this->findById($id);

            $instansi['updated_by'] = $userContext->id;
            $instansi['delete_flag'] = true;
            $instansi->save();

            return $instansi;
        });
    }
}
