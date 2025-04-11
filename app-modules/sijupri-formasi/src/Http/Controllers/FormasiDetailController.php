<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriFormasi\Dtos\FormasiDetailDto;
use Eyegil\SijupriFormasi\Dtos\FormasiResultDto;
use Eyegil\SijupriFormasi\Models\FormasiDetail;
use Eyegil\SijupriFormasi\Services\FormasiDetailService;
use Illuminate\Http\Request;

#[Controller("/api/v1/formasi_detail")]
class FormasiDetailController
{
    public function __construct(
        private FormasiDetailService $formasiDetailService,
    ) {}

    #[Get("/jabatan_list")]
    public function getAvailableJabatanList()
    {
        return $this->formasiDetailService->getAvailableJabatanList();
    }

    #[Get("/formasi/{formasi_id}")]
    public function findByFormasiId($formasi_id)
    {
        return $this->formasiDetailService->findByFormasiId($formasi_id)->map(function (FormasiDetail $formasiDetail) {
            $formasiDetailDto = (new FormasiDetailDto())->fromModel($formasiDetail);
            $formasiDetailDto->jabatan_name = $formasiDetail->jabatan->name;

            $formasiDetailDto->formasi_result_dto_list = [];
            foreach ($formasiDetail->formasiResultList as $formasiResult) {
                $formasiResultDto = (new FormasiResultDto())->fromModel($formasiResult);
                $formasiDetailDto->formasi_result_dto_list[] = $formasiResultDto;
            }

            return $formasiDetailDto;
        });
    }

    #[Get("/unsur/tree/{formasi_id}/{jabatan_code}")]
    public function getUnsurTreeByIdAndJabatanCode(Request $request)
    {
        return $this->formasiDetailService->getUnsurTreeFormasiIdAndJabatanCode($request->formasi_id, $request->jabatan_code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $formasiDetailDto = FormasiDetailDto::fromRequest($request)->validateSave();
        return $this->formasiDetailService->save($formasiDetailDto);
    }

    #[Post("/calculate")]
    public function calculate(Request $request)
    {
        $formasiDetailDto = FormasiDetailDto::fromRequest($request)->validateCalculate();
        return $this->formasiDetailService->calculate($formasiDetailDto);
    }
}
