<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\SijupriAkp\Dtos\Matrix3Dto;
use Eyegil\SijupriAkp\Enums\KategoriDiskrepansi;
use Eyegil\SijupriAkp\Models\Matrix3;
use Illuminate\Support\Facades\DB;

class Matrix3Service
{
    public function findById($id)
    {
        return Matrix3::findOrThrowNotFound($id);
    }

    public function findByMatrixId($matrix_id)
    {
        return Matrix3::where("matrix_id", $matrix_id)->get();
    }

    public function save(Matrix3Dto $matrix3Dto)
    {
        return DB::transaction(function () use ($matrix3Dto) {
            $matrix3 = new Matrix3();
            $matrix3->fromArray($matrix3Dto->toArray());
            $matrix3->save();

            return $matrix3;
        });
    }

    public function updateRank($id, $rank)
    {
        return DB::transaction(function () use ($id, $rank) {
            $matrix3 = $this->findById($id);
            $matrix3->rank_prioritas - $rank;
            $matrix3->save();

            return $matrix3;
        });
    }
}
