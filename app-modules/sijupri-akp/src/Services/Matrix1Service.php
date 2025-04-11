<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\SijupriAkp\Dtos\Matrix1Dto;
use Eyegil\SijupriAkp\Enums\Matrix1Keterangan;
use Eyegil\SijupriAkp\Models\Matrix1;
use Illuminate\Support\Facades\DB;

class Matrix1Service
{

    public function findById($id)
    {
        return Matrix1::findOrThrowNotFound($id);
    }

    public function findByMatrixId($matrix_id)
    {
        return Matrix1::where("matrix_id", $matrix_id)->first();
    }

    public function save(Matrix1Dto $matrix1Dto)
    {
        return DB::transaction(function () use ($matrix1Dto) {
            $matrix1 = new Matrix1();
            $matrix1->fromArray($matrix1Dto->toArray());
            $matrix1->save();

            return $matrix1;
        });
    }

    public function update(Matrix1Dto $matrix1Dto)
    {
        return DB::transaction(function () use ($matrix1Dto) {
            $matrix1 = $this->findById($matrix1Dto->id);
            $matrix1->fromArray($matrix1Dto->toArray());
            $matrix1->score = ((int) $matrix1->nilai_ybs ?? 0) + ((int) $matrix1->nilai_rekan ?? 0) + ((int) $matrix1->nilai_atasan ?? 0);
            if((int) $matrix1->score <= 3) $matrix1->keterangan = Matrix1Keterangan::DKK->name;
            else if((int) $matrix1->score <= 6) $matrix1->keterangan = Matrix1Keterangan::DKK_NON_TRAINING->name;
            else if((int) $matrix1->score <= 7) $matrix1->keterangan = Matrix1Keterangan::NON_DKK->name;
            $matrix1->save();

            return $matrix1;
        });
    }
}
