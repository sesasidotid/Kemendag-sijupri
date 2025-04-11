<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Dtos\AkpRekapDto;
use Eyegil\SijupriAkp\Services\AkpPelatihanTeknisService;
use Eyegil\SijupriAkp\Services\AkpRekapService;
use Eyegil\SijupriMaintenance\Converters\PelatihanTeknisConverter;
use Eyegil\SijupriMaintenance\Dtos\PelatihanTeknisDto;
use Illuminate\Http\Request;

#[Controller("/api/v1/akp_pelatihan_teknis")]
class AkpPelatihanTeknisController
{
    public function __construct(
        private AkpPelatihanTeknisService $akpPelatihanTeknisService,
        private AkpRekapService $akpRekapService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $pelatihanTeknisSearch = $this->akpPelatihanTeknisService->findSearch(new Pageable($request->query()));
        $pelatihanTeknisSearch->setCollection($pelatihanTeknisSearch->getCollection()->map(function ($pelatihanTeknis) {
            return PelatihanTeknisConverter::toDto($pelatihanTeknis);
        }));

        return $pelatihanTeknisSearch;
    }

    #[Get("/instrument/{instrument_id}")]
    public function findByInstrumentId($instrument_id)
    {
        return $this->akpPelatihanTeknisService->findByInstrumentId($instrument_id);
    }

    #[Get("/download/pelatihan")]
    public function downloadTemplate()
    {
        return $this->akpRekapService->downloadTemplate();
    }

    #[Get("/{code}")]
    public function findByCode($code)
    {
        return PelatihanTeknisConverter::toDto($this->akpPelatihanTeknisService->findByCode($code));
    }

    #[Post()]
    public function save(Request $request)
    {
        $pelatihanTeknisDto = PelatihanTeknisDto::fromRequest($request)->validateSave();
        return $this->akpPelatihanTeknisService->save($pelatihanTeknisDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $pelatihanTeknisDto = PelatihanTeknisDto::fromRequest($request)->validateUpdate();
        return $this->akpPelatihanTeknisService->update($pelatihanTeknisDto);
    }

    #[Delete("/{code}")]
    public function delete($code)
    {
        return $this->akpPelatihanTeknisService->delete($code);
    }

    #[Post("/validate/pelatihan")]
    public function validatePelatihan(Request $request)
    {
        $request->validate(["file_dokumen_verifikasi" => "required|string"]);
        $this->akpRekapService->validatePelatihan($request->file_dokumen_verifikasi);
    }

    #[Post("/upload/dokumen_verifikasi")]
    public function uploadKompetensionProof(Request $request)
    {
        $akpRekapDto = AkpRekapDto::fromRequest($request)->validateUploadProof();
        $this->akpRekapService->uploadKompetensionProof($akpRekapDto);
    }

    #[Post("/validate/dokumen_verifikasi")]
    public function validateDokumenVerifikasi(Request $request)
    {
        $akpRekapDto = AkpRekapDto::fromRequest($request)->validateDokumenVerifikasi();
        $this->akpRekapService->validateDokumenVerifikasi($akpRekapDto);
    }
}
