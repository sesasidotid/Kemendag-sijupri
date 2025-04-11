<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriUkom\Dtos\DocumentUkomDto;
use Eyegil\SijupriUkom\Services\DocumentUkomService;
use Illuminate\Http\Request;

#[Controller("/api/v1/document_ukom")]
class DocumentUkomController
{
    public function __construct(
        private DocumentUkomService $documentUkomService,
    ) {}

    #[Get("/all")]
    public function findAll(Request $request)
    {
        return $this->documentUkomService->findAll();
    }

    #[Get("/participant/{participant_ukom_id}")]
    public function findAllByParticipantUkomId($participant_ukom_id)
    {
        return $this->documentUkomService->findAllByParticipantUkomId($participant_ukom_id);
    }

    #[Get("/jenis_ukom/{jenis_ukom}")]
    public function findAllByJenisUkom(Request $request)
    {
        return $this->documentUkomService->findAllByJenisUkom(
            $request->jenis_ukom, 
            $request->query("jabatan_code"), 
            $request->query("jenjang_code"),
            $request->query("is_mengulang"),
        );
    }

    #[Post("/dokumen_persyaratan")]
    public function saveDokumen(Request $request)
    {
        $documentUkom = DocumentUkomDto::fromRequest($request);
        return $this->documentUkomService->saveDokumen($documentUkom);
    }
}
