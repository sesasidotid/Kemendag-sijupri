<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\SijupriFormasi\Dtos\FormasiDetailDto;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Dtos\FormasiResultDto;
use Eyegil\SijupriFormasi\Dtos\FormasiScoreDto;
use Eyegil\SijupriFormasi\Dtos\UnsurDto;
use Eyegil\SijupriFormasi\Models\Formasi;
use Eyegil\SijupriFormasi\Models\FormasiDetail;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Services\JenjangService;
use Eyegil\SijupriMaintenance\Services\UnitKerjaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiDetailService
{
    public function __construct(
        private UnsurService $unsurService,
        private FormasiScoreService $formasiScoreService,
        private FormasiResultService $formasiResultService,
        private UnitKerjaService $unitKerjaService,
        private JenjangService $jenjangService,
    ) {}

    public function findByFormasiIdAndJabatanCode($formasi_id, $jabatan_code)
    {
        return FormasiDetail::where("formasi_id", $formasi_id)->where("jabatan_code", $jabatan_code)->first();
    }

    public function findByIdAndFormasiId($id, $formasi_id)
    {
        return FormasiDetail::where("id", $id)->where("formasi_id", $formasi_id)->first();
    }

    public function getUnsurTreeFormasiIdAndJabatanCode($formasi_id, $jabatan_code)
    {
        $unsurList = $this->unsurService->findByJabatanCode($jabatan_code);

        $formasiDetail = $this->findByFormasiIdAndJabatanCode($formasi_id, $jabatan_code);
        $unsurTreeDto = [];
        $this->toTree($unsurTreeDto, $unsurList, optional($formasiDetail)->id ?? "");

        return $unsurTreeDto;
    }

    public function findByFormasiId($formasi_id)
    {
        return FormasiDetail::where("formasi_id", $formasi_id)->get();
    }

    public function getAvailableJabatanList()
    {
        // $userContext = user_context();

        // $unitKerja = $this->unitKerjaService->findById($userContext->getDetails("unit_kerja_id"));
        // $instansi = $unitKerja->instansi;
        // $unit_kerja_type = ($instansi->instansi_type_code == "IT1") ? "internal" : "external";
        // return Jabatan::whereIn("code", ["JB11", "JB10", "JB8", "JB7", "JB4", "JB1"])->where("type", $unit_kerja_type)->get();

        return Jabatan::whereIn("code", ["JB11", "JB10", "JB8", "JB7", "JB4", "JB1"])->get();
    }

    public function save(FormasiDetailDto $formasiDetailDto)
    {
        DB::transaction(function () use ($formasiDetailDto) {
            $userContext = user_context();

            $formasiDetail = $this->findByFormasiIdAndJabatanCode($formasiDetailDto->formasi_id, $formasiDetailDto->jabatan_code);
            if (!$formasiDetail) {
                $formasiDetail = new FormasiDetail();
                $formasiDetail->fromArray($formasiDetailDto->toArray());
                $formasiDetail->created_by = $userContext->id;
                $formasiDetail->saveWithUUid();
            }

            $formasi = $formasiDetail->formasi;
            $pengali = $formasi->unitKerja->wilayah->pengali;

            $unsurDtoListLookUp = [];
            foreach ($formasiDetailDto->unsur_dto_list as $key => $unsur_dto) {
                $unsurDtoListLookUp[$unsur_dto['id']] = [
                    'data' => (new UnsurDto())->fromArray($unsur_dto)->validateCalculate(),
                    'key' => $key
                ];
            }

            $formasiJenjangResult = [];
            $unsurList = $this->unsurService->findByJabatanCodeAndJenjangCodeNotNull($formasiDetailDto->jabatan_code);
            foreach ($unsurList as $key => $unsur) {
                $unsurDto = new UnsurDto();
                $unsurDto->fromModel($unsur);

                $volume = 0;
                if (isset($unsurDtoListLookUp[$unsur->id])) {
                    $unsurDtoRequest = $unsurDtoListLookUp[$unsur->id]['data'];
                    $volume = $unsurDtoRequest->volume;

                    $formasiResultDto = new FormasiResultDto();
                    $formasiResultDto->total = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) + (($unsur->standart_waktu * $unsurDtoRequest->volume) / 60 / 1250);
                    $formasiResultDto->sdm = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) * $pengali;
                    $formasiResultDto->pembulatan = round($formasiResultDto->sdm);

                    $formasiJenjangResult[$unsurDto->jenjang_code] = $formasiResultDto;
                } else {
                    $formasiResultDto = new FormasiResultDto();
                    $formasiResultDto->total = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) + (($unsur->standart_waktu * 0) / 60 / 1250);
                    $formasiResultDto->sdm = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) * $pengali;
                    $formasiResultDto->pembulatan = round($formasiResultDto->sdm);

                    $formasiJenjangResult[$unsurDto->jenjang_code] = $formasiResultDto;
                }

                $formasiScoreDto = new FormasiScoreDto();
                $formasiScoreDto->value = $volume;
                $formasiScoreDto->score = (($unsur->standart_waktu * $unsurDto->volume) / 60 / 1250);
                $formasiScoreDto->unsur_id = $unsurDto->id;
                $formasiScoreDto->formasi_detail_id = $formasiDetail->id;
                $this->formasiScoreService->save($formasiScoreDto);
            }

            $formasiDetailTotal = 0;
            foreach ($formasiJenjangResult as $jenjang_code => $formasiResultDto) {
                $jenjang = $this->jenjangService->findBycode($jenjang_code);
                $formasiResultDto->jenjang_code = $jenjang->code;
                $formasiResultDto->jenjang_name = $jenjang->name;
                $formasiResultDto->result = $jenjang->total;
                $formasiResultDto->formasi_detail_id = $formasiDetail->id;

                $formasiDetailTotal = $formasiDetailTotal + $formasiResultDto->pembulatan ?? 0;
                $this->formasiResultService->save($formasiResultDto);
            }

            $formasiDetail->total = $formasiDetailTotal;
            $formasiDetail->save();
        });
    }

    public function calculate(FormasiDetailDto $formasiDetailDto)
    {
        $formasi = Formasi::findOrThrowNotFound($formasiDetailDto->formasi_id);
        $pengali = $formasi->unitKerja->wilayah->pengali;

        $unsurDtoListLookUp = [];
        foreach ($formasiDetailDto->unsur_dto_list as $key => $unsur_dto) {
            $unsurDtoListLookUp[$unsur_dto['id']] = [
                'data' => (new UnsurDto())->fromArray($unsur_dto)->validateCalculate(),
                'key' => $key
            ];
        }

        $formasiJenjangResult = [];
        $unsurList = $this->unsurService->findByJabatanCodeAndJenjangCodeNotNull($formasiDetailDto->jabatan_code);
        foreach ($unsurList as $key => $unsur) {
            $unsurDto = new UnsurDto();
            $unsurDto->fromModel($unsur);

            if (isset($unsurDtoListLookUp[$unsur->id])) {
                $unsurDtoRequest = $unsurDtoListLookUp[$unsur->id]['data'];

                $formasiResultDto = new FormasiResultDto();
                $formasiResultDto->total = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) + (($unsur->standart_waktu * $unsurDtoRequest->volume) / 60 / 1250);
                $formasiResultDto->sdm = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) * $pengali;
                $formasiResultDto->pembulatan = round($formasiResultDto->sdm);

                $formasiJenjangResult[$unsurDto->jenjang_code] = $formasiResultDto;
            } else {
                $formasiResultDto = new FormasiResultDto();
                $formasiResultDto->total = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) + (($unsur->standart_waktu * 0) / 60 / 1250);
                $formasiResultDto->sdm = ($formasiJenjangResult[$unsurDto->jenjang_code]->total ?? 0) * $pengali;
                $formasiResultDto->pembulatan = round($formasiResultDto->sdm);

                $formasiJenjangResult[$unsurDto->jenjang_code] = $formasiResultDto;
            }
        }

        $formasiResultDtoList = [];
        foreach ($formasiJenjangResult as $jenjang_code => $formasiResultDto) {
            $jenjang = $this->jenjangService->findBycode($jenjang_code);
            $formasiResultDto->jenjang_code = $jenjang->code;
            $formasiResultDto->jenjang_name = $jenjang->name;
            $formasiResultDtoList[] = $formasiResultDto;
        }

        return $formasiResultDtoList;
    }

    public function updateResult(FormasiDto $formasiDto)
    {
        DB::transaction(function () use ($formasiDto) {
            $userContext = user_context();

            foreach ($formasiDto->formasi_detail_dto_list as $key => $formasi_detail_dto) {
                $formasiDetailDto = (new FormasiDetailDto())->fromArray((array) $formasi_detail_dto)->validateUpdateResult();

                $resultSum = 0;
                foreach ($formasiDetailDto->formasi_result_dto_list as $key => $formasi_result_dto) {
                    $formasiResultDto = (new FormasiResultDto())->fromArray((array) $formasi_result_dto)->validateUpdateResult();
                    $formasiResult = $this->formasiResultService->update($formasiResultDto);

                    $resultSum = $resultSum + $formasiResult->result;
                }

                $formasiDetail = $this->findByIdAndFormasiId($formasiDetailDto->id, $formasiDto->id);
                if (!$formasiDetail) {
                    throw new RecordNotFoundException("formasi_id and formasi_detail_id not found", [
                        "formasi_id" => $formasiDto->id,
                        "formasi_detail_id" => $formasiDetailDto->id,
                    ]);
                }
                $formasiDetail->result = $resultSum;
                $formasiDetail->updated_by = $userContext->id;
                $formasiDetail->save();
            }
        });
    }

    private function toTree(&$unsurTreeDto, $unsurList, $formasi_detail_id)
    {
        foreach ($unsurList as $key => $value) {
            $unsurDto = new UnsurDto();
            $unsurDto->fromArray($value->toArray());

            $unsurChild = $value->child;
            if ($unsurChild && count($unsurChild) > 0) {
                $unsurChildTreeDto = [];
                $this->toTree($unsurChildTreeDto, $unsurChild, $formasi_detail_id);
                $unsurDto->child = $unsurChildTreeDto;
            }

            if ($value->jenjang_code) {
                $pendingFormasiScore = $this->formasiScoreService->findByUnsurIdAndFormasiDetailId($value->id, $formasi_detail_id);
                if ($pendingFormasiScore) {
                    $unsurDto->volume = $pendingFormasiScore->value;
                }
            }

            if ($value->jenjang_code)
                $unsurDto->jenjang_name = $value->jenjang->name;
            $unsurTreeDto[] = $unsurDto;
        }
    }
}
