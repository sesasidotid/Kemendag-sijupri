<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\SijupriAkp\Dtos\Matrix2Dto;
use Eyegil\SijupriAkp\Enums\JenisPengembanganKompetensi;
use Eyegil\SijupriAkp\Enums\PenyebabDiskrepansiUtama;
use Eyegil\SijupriAkp\Models\Matrix2;
use Illuminate\Support\Facades\DB;

class Matrix2Service
{
    public function findById($id)
    {
        return Matrix2::findOrThrowNotFound($id);
    }

    public function findByMatrixId($matrix_id)
    {
        return Matrix2::where("matrix_id", $matrix_id)->first();
    }

    public function save(Matrix2Dto $matrix2Dto)
    {
        return DB::transaction(function () use ($matrix2Dto) {
            $matrix2 = new Matrix2();
            $matrix2->fromArray($matrix2Dto->toArray());
            $matrix2->save();

            return $matrix2;
        });
    }
}
