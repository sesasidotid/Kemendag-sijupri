<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\SuratRekomTemplateDto;
use Eyegil\SijupriMaintenance\Dtos\SystemConfigurationDto;
use Illuminate\Http\Request;
use Eyegil\SijupriMaintenance\Services\SuratRekomTemplateService;

#[Controller("/api/v1/surat_rekom")]
class SuratRekomTemplateController
{
    public function __construct(
        private SuratRekomTemplateService $suratRekomTemplateService
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->suratRekomTemplateService->findSearch(new Pageable($request->query()));
    }

    #[Get("/download/{id}")]
    public function download($id)
    {
        return response()->download($this->suratRekomTemplateService->download($id));
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        $this->suratRekomTemplateService->delete($id);
    }

    #[Post()]
    public function setUpRekom(Request $request)
    {
        $suratRekomTemplateDto = SuratRekomTemplateDto::fromRequest($request)->validateSetUp();
        return $this->suratRekomTemplateService->setUpRekom($suratRekomTemplateDto);
    }

    #[Get("/template/{code}")]
    public function findTemplate($code)
    {
        $suratRekomTemplate = $this->suratRekomTemplateService->findTemplate($code);
        return [
            "base_template" => $suratRekomTemplate->base_template,
            "template" => $suratRekomTemplate->template,
        ];
    }

    #[Post("/generate_ukom")]
    public function generateUkomRekom()
    {
        return $this->suratRekomTemplateService->generateUkomRekom();
    }

    #[Post("/upload_ukom")]
    public function uploadRekomendasiUkomBatch(Request $request)
    {
        return $this->suratRekomTemplateService->uploadRekomendasiUkomBatch($request->compressed_file);
    }
}
