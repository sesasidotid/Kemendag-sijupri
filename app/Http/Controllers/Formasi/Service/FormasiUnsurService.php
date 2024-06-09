<?php

namespace App\Http\Controllers\Formasi\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\Formasi\FormasiUnsur;
use Illuminate\Support\Facades\DB;

class FormasiUnsurService extends FormasiUnsur
{
    use SearchService;
    
    public function childUnsur($formasi_id)
    {
        $userContex = auth()->user();
        return FormasiUnsur::distinct()->leftJoin('tbl_formasi_score', function ($join) use ($formasi_id) {
            $join->on('tbl_formasi_unsur.id', 'tbl_formasi_score.formasi_unsur_id')
                ->where('tbl_formasi_score.formasi_id', $formasi_id);
        })
            ->select('tbl_formasi_unsur.*', 'tbl_formasi_score.volume as volume')
            ->where('tbl_formasi_unsur.parent_id', $this->main_id)
            ->where('tbl_formasi_unsur.jabatan_code', $this->jabatan_code)
            ->where('tbl_formasi_unsur.delete_flag', false)
            ->get();
    }

    public function childUnsurTask($formasi_id)
    {
        return FormasiUnsur::distinct()->leftJoin('tbl_formasi_score', 'tbl_formasi_unsur.id', 'tbl_formasi_score.formasi_unsur_id')
            ->leftJoin('tbl_formasi', function ($join) use ($formasi_id) {
                $join->on('tbl_formasi_score.formasi_id', 'tbl_formasi.id')
                    ->where('tbl_formasi.id', $formasi_id)
                    ->where('tbl_formasi.delete_flag', false)
                    ->where('tbl_formasi.inactive_flag', false)
                    ->where('tbl_formasi.task_status', null)
                    ->where('tbl_formasi.task_status', TaskStatus::PENDING);
            })
            ->select('tbl_formasi_unsur.*', 'tbl_formasi_score.volume as volume')
            ->where('tbl_formasi_unsur.parent_id', $this->main_id)
            ->where('tbl_formasi_unsur.jabatan_code', $this->jabatan_code)
            ->where('tbl_formasi_unsur.delete_flag', false)
            ->get();
    }

    public function childUnsurApproved($formasi_id)
    {
        return FormasiUnsur::leftJoin('tbl_formasi_score', 'tbl_formasi_unsur.id', '=', 'tbl_formasi_score.formasi_unsur_id')
            ->leftJoin('tbl_formasi', function ($join) use ($formasi_id) {
                $join->on('tbl_formasi_score.formasi_id', '=', 'tbl_formasi.id')
                    ->where('tbl_formasi.id', '=', $formasi_id)
                    ->where('tbl_formasi.delete_flag', '=', false)
                    ->where('tbl_formasi.inactive_flag', '=', false)
                    ->where('tbl_formasi.task_status', '=', null)
                    ->where('tbl_formasi.task_status', TaskStatus::APPROVE);
            })
            ->select('tbl_formasi_unsur.*', 'tbl_formasi_score.volume as volume')
            ->where('tbl_formasi_unsur.parent_id', $this->main_id)
            ->where('tbl_formasi_unsur.jabatan_code', $this->jabatan_code)
            ->where('tbl_formasi_unsur.delete_flag', false)
            ->get();
    }

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($id)
    {
        return $this
            ->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findAllParent($jabatan_code)
    {
        return $this
            ->where('lvl', 1)
            ->where('jabatan_code', $jabatan_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
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
