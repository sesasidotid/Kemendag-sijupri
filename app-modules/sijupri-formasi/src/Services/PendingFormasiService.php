<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\SijupriFormasi\Models\PendingFormasi;
use Eyegil\SijupriFormasi\Models\PendingFormasiResult;
use Eyegil\SijupriFormasi\Models\PendingFormasiScore;
use Eyegil\SijupriFormasi\Models\Unsur;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PendingFormasiService
{
    public function __construct(
        private UnsurService $unsurService,
    ) {}

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return PendingFormasi::where('unit_kerja_id', $unit_kerja_id)->get();
    }

    public function findByUnitKerjaIdAndJabatanCode($unit_kerja_id, $jabatan_code)
    {
        return PendingFormasi::where('unit_kerja_id', $unit_kerja_id)->where('jabatan_code', $jabatan_code)->first();
    }

    public function findUnsurTreeByUnitKerjaIdAndJabatanCode($unit_kerja_id, $jabatan_code)
    {
        $unsurList = Unsur::where("jabatan_code", $jabatan_code)
            ->where("delete_flag", false)
            ->where("parent_id", null)
            ->get();

        $pendingFormasi = $this->findByUnitKerjaIdAndJabatanCode($unit_kerja_id, $jabatan_code);
        $unsurTreeDto = [];
        $this->toTree($unsurTreeDto, $unsurList, $pendingFormasi->id ?? "");

        return $unsurTreeDto;
    }

    public function save($unsur_list, $pengali, $unit_kerja_id, $jabatan_code)
    {
        $pendingFormasi = PendingFormasi::where('unit_kerja_id', $unit_kerja_id)
            ->where('jabatan_code', $jabatan_code)->first();
        if (!$pendingFormasi) {
            $pendingFormasi = new PendingFormasi();
            $pendingFormasi->unit_kerja_id = $unit_kerja_id;
            $pendingFormasi->jabatan_code = $jabatan_code;
            $pendingFormasi->save();
        }

        DB::transaction(function () use ($pendingFormasi, $unsur_list, $pengali, $unit_kerja_id, $jabatan_code) {
            $formasiJenjangResult = [];

            PendingFormasiScore::where('pending_formasi_id', $pendingFormasi->id)->delete();
            PendingFormasiResult::where('pending_formasi_id', $pendingFormasi->id)->delete();

            foreach ($unsur_list as $key => $unsur_data) {
                $unsur = $this->unsurService->findById($unsur_data['id']);

                $pendingFormasiScore = new PendingFormasiScore();
                $pendingFormasiScore->value = $unsur_data['volume'];
                $pendingFormasiScore->score = (($unsur->standart_waktu * $unsur_data['volume']) / 60 / 1250);
                $pendingFormasiScore->unsur_id = $unsur->id;
                $pendingFormasiScore->pending_formasi_id = $pendingFormasi->id;
                $pendingFormasiScore->save();

                $jenjang_code = $unsur->jenjang_code;
                $formasiJenjangResult[$jenjang_code]['total'] = ($formasiJenjangResult[$jenjang_code]['total'] ?? 0) + $pendingFormasiScore->score;
                $formasiJenjangResult[$jenjang_code]['sdm'] = ($formasiJenjangResult[$jenjang_code]['total'] ?? 0) * $pengali;
                $formasiJenjangResult[$jenjang_code]['pembulatan'] = round($formasiJenjangResult[$jenjang_code]['sdm']);
            }

            $total = 0;
            foreach ($formasiJenjangResult as $jenjang_code => $value) {
                $jenjang = Jenjang::findOrThrowNotFound($jenjang_code);
                $total = $total + $value['pembulatan'];

                $pendingFormasiResult = new PendingFormasiResult();
                $pendingFormasiResult->sdm = $value['sdm'];
                $pendingFormasiResult->pembulatan = $value['pembulatan'];
                $pendingFormasiResult->result = $value['total'];
                $pendingFormasiResult->jenjang_code = $jenjang->code;
                $pendingFormasiResult->pending_formasi_id = $pendingFormasi->id;
                $pendingFormasiResult->save();
            }


            $pendingFormasi->total = $total;
            $pendingFormasi->save();
        });
    }

    private function toTree(&$unsurTreeDto, $unsurList, $pending_formasi_id)
    {
        foreach ($unsurList as $key => $value) {
            $unsurDto = $value->toArray();

            $unsurChild = $value->child;
            if ($unsurChild && count($unsurChild) > 0) {
                $unsurChildDto = [];
                $this->toTree($unsurChildDto, $unsurChild, $pending_formasi_id);
                $unsurDto['child'] = $unsurChildDto;
            }

            $pendingFormasiScore = $value->pendingFormasiScoreWithPendingFormasiId($pending_formasi_id)->first();
            if ($pendingFormasiScore) {
                $unsurDto['volume'] = $pendingFormasiScore->value;
            }

            if ($value->jenjang_code)
                $unsurDto['jenjang_name'] = $value->jenjang->name;
            $unsurTreeDto[] = $unsurDto;
        }
    }
}
