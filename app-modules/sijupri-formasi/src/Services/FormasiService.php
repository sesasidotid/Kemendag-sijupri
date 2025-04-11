<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Enums\FormasiStatus;
use Eyegil\SijupriFormasi\Models\Formasi;
use Eyegil\SijupriFormasi\Models\FormasiResult;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiService
{
    const workflow_name = "formasi_task";

    public function __construct(
        private UnsurService $unsurService,
        private FormasiDetailService $formasiDetailService,
        private FormasiScoreService $formasiScoreService,
        private FormasiResultService $formasiResultService,
        private FormasiDokumenService $formasiDokumenService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("formasi_status", FormasiStatus::ACTIVE->value);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(Formasi::class, ["unitKerja"]);
    }

    public function findById($id)
    {
        return Formasi::findOrThrowNotFound($id);
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return Formasi::where("unit_kerja_id", $unit_kerja_id)
            ->where("formasi_status", FormasiStatus::ACTIVE->value)
            ->first();
    }

    public function findHistoryByUnitKerjaId($unit_kerja_id)
    {
        return Formasi::where("unit_kerja_id", $unit_kerja_id)
            ->where("formasi_status", FormasiStatus::HISTORY->value)
            ->get();
    }

    public function findByUnitKerjaIdAndJabatanCode($unit_kerja_id, $jabatan_code)
    {
        return Formasi::where("unit_kerja_id", $unit_kerja_id)
            ->where("jabatan_code", $jabatan_code)
            ->where("delete_flag", false)
            ->first();
    }

    public function findDetailFormasiByUnitKerjaIdAndFormasiStatus($unit_kerja_id, $formasi_status)
    {
        return Formasi::where("unit_kerja_id", $unit_kerja_id)->where("formasi_status", $formasi_status)->get();
    }

    public function calculateProvinsi($provinsi_id)
    {
        return FormasiResult::select(
            'mnt_jabatan.code as jabatan_code',
            'mnt_jabatan.name as jabatan_name',
            'mnt_jenjang.code as jenjang_code',
            'mnt_jenjang.name as jenjang_name',
            DB::raw('SUM(for_formasi_result.result) as result_sum') // Fixed table name
        )
            ->join('for_formasi_detail', 'for_formasi_result.formasi_detail_id', '=', 'for_formasi_detail.id')
            ->join('for_formasi', 'for_formasi_detail.formasi_id', '=', 'for_formasi.id')
            ->join('mnt_unit_kerja', 'for_formasi.unit_kerja_id', '=', 'mnt_unit_kerja.id')
            ->join('mnt_instansi', 'mnt_unit_kerja.instansi_id', '=', 'mnt_instansi.id')
            ->join('mnt_jabatan', 'for_formasi_detail.jabatan_code', '=', 'mnt_jabatan.code')
            ->join('mnt_jenjang', 'for_formasi_result.jenjang_code', '=', 'mnt_jenjang.code')
            ->where("for_formasi.formasi_status", FormasiStatus::ACTIVE->value)
            ->where('mnt_instansi.provinsi_id', $provinsi_id)
            ->groupBy(
                'mnt_jabatan.code',
                'mnt_jabatan.code',
                'mnt_jabatan.name',
                'mnt_jenjang.code',
                'mnt_jenjang.code',
                'mnt_jenjang.name'
            )
            ->get()
            ->groupBy('jabatan_code')
            ->map(function ($items) {
                return [
                    'jabatan_code' => $items->first()->jabatan_code,
                    'jabatan_name' => $items->first()->jabatan_name,
                    'jenjang_sum_list' => $items->map(function ($item) {
                        return [
                            'jenjang_code' => $item->jenjang_code,
                            'jenjang_name' => $item->jenjang_name,
                            'result_sum' => $item->result_sum,
                        ];
                    })->values(),
                ];
            })->values();
    }

    public function calculateKabKota($kab_kota_id)
    {
        return FormasiResult::select(
            'mnt_jabatan.code as jabatan_code',
            'mnt_jabatan.name as jabatan_name',
            'mnt_jenjang.code as jenjang_code',
            'mnt_jenjang.name as jenjang_name',
            DB::raw('SUM(for_formasi_result.result) as result_sum') // Fixed table name
        )
            ->join('for_formasi_detail', 'for_formasi_result.formasi_detail_id', '=', 'for_formasi_detail.id')
            ->join('for_formasi', 'for_formasi_detail.formasi_id', '=', 'for_formasi.id')
            ->join('mnt_unit_kerja', 'for_formasi.unit_kerja_id', '=', 'mnt_unit_kerja.id')
            ->join('mnt_instansi', 'mnt_unit_kerja.instansi_id', '=', 'mnt_instansi.id')
            ->join('mnt_jabatan', 'for_formasi_detail.jabatan_code', '=', 'mnt_jabatan.code')
            ->join('mnt_jenjang', 'for_formasi_result.jenjang_code', '=', 'mnt_jenjang.code')
            ->where("for_formasi.formasi_status", FormasiStatus::ACTIVE->value)
            ->where(function ($query) use ($kab_kota_id) {
                $query->where('mnt_instansi.kabupaten_id', $kab_kota_id)
                    ->orWhere('mnt_instansi.kota_id', $kab_kota_id);
            })
            ->groupBy(
                'mnt_jabatan.code',
                'mnt_jabatan.code',
                'mnt_jabatan.name',
                'mnt_jenjang.code',
                'mnt_jenjang.code',
                'mnt_jenjang.name'
            )
            ->get()
            ->groupBy('jabatan_code')
            ->map(function ($items) {
                return [
                    'jabatan_code' => $items->first()->jabatan_code,
                    'jabatan_name' => $items->first()->jabatan_name,
                    'jenjang_sum_list' => $items->map(function ($item) {
                        return [
                            'jenjang_code' => $item->jenjang_code,
                            'jenjang_name' => $item->jenjang_name,
                            'result_sum' => $item->result_sum,
                        ];
                    })->values(),
                ];
            })->values();
    }

    public function calculateUnitKerja($unit_kerja_id)
    {
        return FormasiResult::select(
            'mnt_jabatan.code as jabatan_code',
            'mnt_jabatan.name as jabatan_name',
            'mnt_jenjang.code as jenjang_code',
            'mnt_jenjang.name as jenjang_name',
            DB::raw('SUM(for_formasi_result.result) as result_sum') // Fixed table name
        )
            ->join('for_formasi_detail', 'for_formasi_result.formasi_detail_id', '=', 'for_formasi_detail.id')
            ->join('for_formasi', 'for_formasi_detail.formasi_id', '=', 'for_formasi.id')
            ->join('mnt_unit_kerja', 'for_formasi.unit_kerja_id', '=', 'mnt_unit_kerja.id')
            ->join('mnt_jabatan', 'for_formasi_detail.jabatan_code', '=', 'mnt_jabatan.code')
            ->join('mnt_jenjang', 'for_formasi_result.jenjang_code', '=', 'mnt_jenjang.code')
            ->where("for_formasi.formasi_status", FormasiStatus::ACTIVE->value)
            ->where('mnt_unit_kerja.id', $unit_kerja_id)
            ->groupBy(
                'mnt_jabatan.code',
                'mnt_jabatan.code',
                'mnt_jabatan.name',
                'mnt_jenjang.code',
                'mnt_jenjang.code',
                'mnt_jenjang.name'
            )
            ->get()
            ->groupBy('jabatan_code')
            ->map(function ($items) {
                return [
                    'jabatan_code' => $items->first()->jabatan_code,
                    'jabatan_name' => $items->first()->jabatan_name,
                    'jenjang_sum_list' => $items->map(function ($item) {
                        return [
                            'jenjang_code' => $item->jenjang_code,
                            'jenjang_name' => $item->jenjang_name,
                            'result_sum' => $item->result_sum,
                        ];
                    })->values(),
                ];
            })->values();
    }

    public function save(FormasiDto $formasiDto)
    {
        return  DB::transaction(function () use ($formasiDto) {
            $userContext = user_context();

            $formasi = new Formasi();
            $formasi->fromArray($formasiDto->toArray());
            $formasi->created_by = $userContext->id;
            $formasi->saveWithUUid();

            return $formasi;
        });
    }

    public function update(FormasiDto $formasiDto)
    {
        DB::transaction(function () use ($formasiDto) {
            $formasi = $this->findById($formasiDto->id);
            $this->setAllFormasiStatusHistoryByUnitKerjaId($formasi->unit_kerja_id);

            $formasi->rekomendasi = $formasiDto->rekomendasi;
            $formasi->formasi_status = FormasiStatus::ACTIVE;
            $formasi->save();

            $this->formasiDokumenService->save($formasiDto);
        });
    }

    public function setAllFormasiStatusHistoryByUnitKerjaId($unit_kerja_id)
    {
        DB::transaction(function () use ($unit_kerja_id) {
            Formasi::where('unit_kerja_id', $unit_kerja_id)->update([
                "formasi_status" => FormasiStatus::HISTORY->value
            ]);
        });
    }
}
