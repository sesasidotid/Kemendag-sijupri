<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Dtos\BidangJabatanDto;
use Eyegil\SijupriMaintenance\Models\BidangJabatan;
use Illuminate\Support\Facades\DB;

class BidangJabatanService
{
    public function findAll()
    {
        return BidangJabatan::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findAllByJabatan($jabatan_code)
    {
        return BidangJabatan::where('jabatan_code', $jabatan_code)->get();
    }

    public function findById($id)
    {
        return BidangJabatan::findOrThrowNotFound($id);
    }

    public function save(BidangJabatanDto $bidangJabatanDto)
    {
        return DB::transaction(function () use ($bidangJabatanDto) {
            $userContext = user_context();

            $bidangJabatan = new BidangJabatan();
            $bidangJabatan->fromArray($bidangJabatanDto->toArray());
            $bidangJabatan->code = "BJ" . BidangJabatan::count() + 1;
            $bidangJabatan->created_by = $userContext->id;
            $bidangJabatan->save();

            return $bidangJabatan;
        });
    }

    public function update(BidangJabatanDto $bidangJabatanDto)
    {
        return DB::transaction(function () use ($bidangJabatanDto) {
            $userContext = user_context();

            $bidangJabatan = $this->findById($bidangJabatanDto->code);
            $bidangJabatan->name = $bidangJabatanDto->name;
            $bidangJabatan->created_by = $userContext->id;
            $bidangJabatan->save();

            return $bidangJabatan;
        });
    }

    public function delete($code)
    {
        return DB::transaction(function () use ($code) {
            $userContext = user_context();

            $bidangJabatan = $this->findById($code);
            $bidangJabatan->updated_by = $userContext->id;
            $bidangJabatan->delete_flag = true;
            $bidangJabatan->save();

            return $bidangJabatan;
        });
    }
}
