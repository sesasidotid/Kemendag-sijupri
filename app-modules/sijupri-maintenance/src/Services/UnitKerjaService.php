<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\UnitKerjaDto;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Support\Facades\DB;

class UnitKerjaService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->with(['instansi'])->searchHas(UnitKerja::class, ['instansi']);
    }

    public function findAll()
    {
        return UnitKerja::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return UnitKerja::findOrThrowNotFound($id);
    }

    public function findByInstansiId($instansi_id)
    {
        return UnitKerja::where("instansi_id", $instansi_id)->get();
    }

    public function save(UnitKerjaDto $unitKerjaDto)
    {
        return DB::transaction(function () use ($unitKerjaDto) {
            $userContext = user_context();

            $unitKerja = new UnitKerja();
            $unitKerja->fromArray($unitKerjaDto->toArray());
            $unitKerja->created_by = $userContext->id;

            $unitKerja->saveWithUUid();

            return $unitKerja;
        });
    }

    public function update(UnitKerjaDto $unitKerjaDto)
    {
        return DB::transaction(function () use ($unitKerjaDto) {
            $userContext = user_context();

            $unitKerja = $this->findById($unitKerjaDto->id);
            $unitKerja->fromArray($unitKerjaDto->toArray());
            $unitKerja->updated_by = $userContext->id;

            $unitKerja->save();

            return $unitKerja;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $unitKerja = $this->findById($id);

            $unitKerja['updated_by'] = $userContext->id;
            $unitKerja['delete_flag'] = true;
            $unitKerja->save();

            return $unitKerja;
        });
    }
}
