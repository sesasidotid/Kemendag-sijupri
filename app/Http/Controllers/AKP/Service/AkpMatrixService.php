<?php

namespace App\Http\Controllers\AKP\Service;

use App\Http\Controllers\SearchService;
use App\Models\AKP\AkpMatrix;
use Illuminate\Support\Facades\DB;

class AkpMatrixService extends AkpMatrix
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id): ?AkpMatrixService
    {
        return $this
            ->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByAkpIdAndRelevansi($akp_id, $relevansi)
    {
        return $this
            ->where('akp_id', $akp_id)
            ->where('relevansi', $relevansi)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByAkpIdAndAkpPertanyaanId($akp_id, $akp_pertanyaan_id)
    {
        return $this
            ->where('akp_id', $akp_id)
            ->where('akp_pertanyaan_id', $akp_pertanyaan_id)
            ->where('delete_flag', false)
            ->first();
    }

    public function customSaveAll(array $akpMatrixNew, $akp_id, $penilai)
    {
        DB::transaction(function () use ($akpMatrixNew, $akp_id, $penilai) {
            $userContext = auth()->user();

            foreach ($akpMatrixNew as $akp_pertanyaan_id => $nilai) {
                $akpMatrix = $this->findByAkpIdAndAkpPertanyaanId($akp_id, $akp_pertanyaan_id);
                if ($akpMatrix) {
                    $akpMatrix->$penilai = $nilai;
                    $akpMatrix->akp_pertanyaan_id = $akp_pertanyaan_id;
                    $akpMatrix->created_by = $userContext->nip;
                    $akpMatrix->akp_id = $akp_id;
                    $akpMatrix->customUpdate();
                } else {
                    $akpMatrix = new AkpMatrixService();
                    $akpMatrix->$penilai = $nilai;
                    $akpMatrix->akp_pertanyaan_id = $akp_pertanyaan_id;
                    $akpMatrix->created_by = $userContext->nip;
                    $akpMatrix->akp_id = $akp_id;
                    $akpMatrix->customSave();
                }
            }
        });
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
        });
    }
    public function updateAllByAkpIdAndPertanyaanAkpId(array $dataList, $pelatihan_id)
    {
        DB::transaction(function () use ($dataList, $pelatihan_id) {
            foreach ($dataList as $key => $value) {
                if (is_array($value)) {
                    $value['akp_id'] = $pelatihan_id;
                    $value['akp_pertanyaan_id'] = $key;
                    $this->updateByIdAndPertanyaanAkpId($value);
                }
            }
        });
    }

    public function updateByIdAndPertanyaanAkpId(array $matrixAKPNew)
    {
        return DB::transaction(function () use ($matrixAKPNew) {
            $matrixAKP = new AkpMatrix();
            $matrixAKP->fill($matrixAKPNew);
            $matrixAKP->where('akp_id', $matrixAKPNew['akp_id'])
                ->where('akp_pertanyaan_id', $matrixAKPNew['akp_pertanyaan_id'])
                ->update($matrixAKPNew);

            return $matrixAKP;
        });
    }

    public function customUpdate()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
        });
    }

    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
        });
    }
}
