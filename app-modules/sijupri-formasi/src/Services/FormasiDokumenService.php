<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\SijupriFormasi\Converters\FormasiDokumenConverter;
use Eyegil\SijupriFormasi\Dtos\FormasiDokumenDto;
use Eyegil\SijupriFormasi\Dtos\FormasiDto;
use Eyegil\SijupriFormasi\Models\FormasiDokumen;
use Eyegil\SijupriMaintenance\Dtos\DokumenPersyaratanDto;
use Eyegil\SijupriMaintenance\Services\DokumenPersyaratanService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiDokumenService
{
    public function __construct(
        private StorageService $storageService,
        private DokumenPersyaratanService $dokumenPersyaratanService,
    ) {}

    public function findById($id)
    {
        return FormasiDokumen::findOrThrowNotFound($id);
    }

    public function findByDokumenPersyaratanId($dokumen_persyaratan_id)
    {
        return $this->dokumenPersyaratanService->findById($dokumen_persyaratan_id);
    }

    public function findAll()
    {
        return $this->dokumenPersyaratanService->findByAssociation("for_formasi")->map(function ($dokumenPersyaratan) {
            return FormasiDokumenConverter::dokumenPersyaratanToDto($dokumenPersyaratan);
        });
    }

    public function findAllByUnitKerjaId($unit_kerja_id)
    {
        return FormasiDokumen::where("unit_kerja_id", $unit_kerja_id)->get()->map(function ($formasiDokumen) {
            $formasiDokumenDto = FormasiDokumenConverter::toDto($formasiDokumen);
            $formasiDokumenDto->dokumen_url = $this->storageService->getUrl("system", "formasi", $formasiDokumen->dokumen);
            return $formasiDokumenDto;
        });
    }

    public function findAllByFormasiId($formasi_id)
    {
        return FormasiDokumen::where("formasi_id", $formasi_id)->get()->map(function ($formasiDokumen) {
            $formasiDokumenDto = FormasiDokumenConverter::toDto($formasiDokumen);
            $formasiDokumenDto->dokumen_url = $this->storageService->getUrl("system", "formasi", $formasiDokumen->dokumen);
            return $formasiDokumenDto;
        });
    }

    public function save(FormasiDto $formasiDto)
    {
        return DB::transaction(function () use ($formasiDto) {
            foreach ($formasiDto->formasi_dokumen_list as $key => $formasi_dokumen_dto) {
                $formasiDokumen = new FormasiDokumen();
                $formasiDokumen->fromArray((array) $formasi_dokumen_dto);
                $formasiDokumen->formasi_id = $formasiDto->id;
                $formasiDokumen->saveWithUUid();
            }
        });
    }

    public function saveDokumen(FormasiDokumenDto $formasiDokumenDto)
    {
        return DB::transaction(function () use ($formasiDokumenDto) {
            $dokumenPersyaratanDto = new DokumenPersyaratanDto();
            $dokumenPersyaratanDto->name = $formasiDokumenDto->dokumen_persyaratan_name;
            $dokumenPersyaratanDto->association = "for_formasi";

            return $this->dokumenPersyaratanService->save($dokumenPersyaratanDto);
        });
    }

    public function updateDokumenStatus($id, $dokumen_status)
    {
        return DB::transaction(function () use ($id, $dokumen_status) {
            $userContext = user_context();
            $formasiDokumen = $this->findById($id);
            $formasiDokumen->dokumen_status = $dokumen_status;
            $formasiDokumen->updated_by = $userContext->id;
            $formasiDokumen->save();

            return $formasiDokumen;
        });
    }
}
