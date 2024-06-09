<?php

namespace App\Http\Controllers\Siap\Service;

use App\Http\Controllers\SearchService;
use App\Models\Siap\UnitKerja;
use Illuminate\Support\Facades\DB;

class UnitKerjaService extends UnitKerja
{
    use SearchService;
    
    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findWith(array $attributes)
    {
        return $this->where(function ($query) use ($attributes) {
            foreach ($attributes as $column => $value) {
                $query->orWhere($column, '=', $value);
            }
            $query->where('delete_flag', '=', false);
        })->get();
    }

    public function findById($id): ?UnitKerjaService
    {
        return $this->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByProvinsiId($provinsi_id)
    {
        return $this->where('provinsi_id', $provinsi_id)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByKabupatenId($kabupaten_id)
    {
        return $this->where('kabupaten_id', $kabupaten_id)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByKotaId($kota_id)
    {
        return $this->where('kota_id', $kota_id)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByOperasional($operasional)
    {
        return $this->where('operasional', $operasional)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByTipeInstansiCode($tipe_instansi_code)
    {
        return $this
            ->where('tipe_instansi_code', $tipe_instansi_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByTipeInstansiCodeAndInstansiId($tipe_instansi_code, $instansi_id)
    {
        return $this->leftJoin('tbl_tipe_instansi', 'tbl_tipe_instansi.code', '=', 'tbl_unit_kerja.tipe_instansi_code')
            ->leftJoin('tbl_instansi', function ($join) use ($tipe_instansi_code) {
                $join->on('tbl_tipe_instansi.code', '=', 'tbl_instansi.tipe_instansi_code')
                    ->where('tbl_instansi.tipe_instansi_code', '=', $tipe_instansi_code);
            })
            ->select('tbl_unit_kerja.*')
            ->where('tbl_instansi.id', $instansi_id)
            ->get();
    }

    public function findByFormasiTaskStatusNot($task_status)
    {
        return $this->leftJoin('tbl_formasi', 'tbl_formasi.unit_kerja_id', '=', 'tbl_unit_kerja.id')
            ->select('tbl_unit_kerja.*')
            ->distinct()
            ->where('tbl_formasi.task_status', '!=', $task_status)
            ->get();
    }

    public function findByFormasiTaskStatus($task_status)
    {
        return $this->leftJoin('tbl_formasi', 'tbl_formasi.unit_kerja_id', '=', 'tbl_unit_kerja.id')
            ->select('tbl_unit_kerja.*')
            ->distinct()
            ->where('tbl_formasi.task_status', $task_status)
            ->get();
    }

    public function customSave()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
            return $this;
        });
    }

    public function customUpdate()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
            return $this;
        });
    }

    public function customDelete()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
            return $this;
        });
    }
}
