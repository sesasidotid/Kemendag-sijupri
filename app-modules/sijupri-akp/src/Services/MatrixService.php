<?php

namespace Eyegil\SijupriAkp\Services;

use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Dtos\AkpRekapDto;
use Eyegil\SijupriAkp\Dtos\Matrix1Dto;
use Eyegil\SijupriAkp\Dtos\Matrix2Dto;
use Eyegil\SijupriAkp\Dtos\Matrix3Dto;
use Eyegil\SijupriAkp\Dtos\MatrixDto;
use Eyegil\SijupriAkp\Models\Matrix;
use Illuminate\Support\Facades\DB;

class MatrixService
{
    public function __construct(
        private Matrix1Service $matrix1Service,
        private Matrix2Service $matrix2Service,
        private Matrix3Service $matrix3Service,
        private AkpRekapService $akpRekapService
    ) {}

    public function findById($id)
    {
        return Matrix::findOrThrowNotFound($id);
    }

    public function findByAkpIdAndPertanyaanId($akp_id, $pertanyaan_id)
    {
        return Matrix::where("akp_id", $akp_id)->where("pertanyaan_id", $pertanyaan_id)->firstOrThrowNotFound();
    }

    public function findByNip($nip)
    {
        return Matrix::where("nip", $nip)->get();
    }

    public function findByAkpId($akp_id)
    {
        return Matrix::where("akp_id", $akp_id)
            ->orderBy("idx", "asc")
            ->orderBy('kategori_instrument_id', 'asc')
            ->get();
    }

    public function save(AkpDto $akpDto)
    {
        return DB::transaction(function () use ($akpDto) {
            $userContext = user_context();
            foreach ($akpDto->matrix_dto_list as $key => $matrix_dto) {
                $matrixDto = (new MatrixDto())->fromArray((array) $matrix_dto);

                $matrix = new Matrix();
                $matrix->fromArray($matrixDto->toArray());
                $matrix->created_by = $userContext->id;
                $matrix->akp_id = $akpDto->id;
                $matrix->save();

                $matrix1Dto = (new Matrix1Dto())->fromArray((array) $matrixDto->matrix1_dto);
                $matrix1Dto->matrix_id = $matrix->id;
                $this->matrix1Service->save($matrix1Dto);

                if ($matrixDto->matrix2_dto) {
                    $matrix2Dto = (new Matrix2Dto())->fromArray((array) $matrixDto->matrix2_dto);
                    $matrix2Dto->matrix_id = $matrix->id;
                    $this->matrix2Service->save($matrix2Dto);
                }

                if ($matrixDto->matrix3_dto) {
                    $matrix3Dto = (new Matrix3Dto())->fromArray((array) $matrixDto->matrix3_dto);
                    $matrix3Dto->matrix_id = $matrix->id;
                    $this->matrix3Service->save($matrix3Dto);
                }

                if ($matrixDto->akp_rekap_dto) {
                    $akpRekapDto = (new AkpRekapDto())->fromArray((array) $matrixDto->akp_rekap_dto);
                    $akpRekapDto->matrix_id = $matrix->id;
                    $this->akpRekapService->save($akpRekapDto);
                }
            }

            return $matrix;
        });
    }
}
