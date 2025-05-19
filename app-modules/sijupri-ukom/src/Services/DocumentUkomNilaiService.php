<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\SijupriUkom\Converters\DocumentUkomConverter;
use Eyegil\SijupriMaintenance\Dtos\DokumenPersyaratanDto;
use Eyegil\SijupriMaintenance\Services\DokumenPersyaratanService;
use Eyegil\SijupriMaintenance\Services\JabatanService;
use Eyegil\SijupriMaintenance\Services\JenjangService;
use Eyegil\SijupriUkom\Dtos\DocumentUkomDto;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Enums\JenisUkom;
use Eyegil\SijupriUkom\Models\DocumentUkom;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Support\Facades\DB;

class DocumentUkomService
{
    public function __construct(
        private StorageService $storageService,
        private DokumenPersyaratanService $dokumenPersyaratanService,
        private JabatanService $jabatanService,
        private JenjangService $jenjangService,
    ) {}

    public function findById($id)
    {
        return DocumentUkom::findOrThrowNotFound($id);
    }

    public function findByDokumenPersyaratanId($dokumen_persyaratan_id)
    {
        return $this->dokumenPersyaratanService->findById($dokumen_persyaratan_id);
    }

    public function findAll()
    {
        return $this->dokumenPersyaratanService->findByAssociation("ukm_participant")->map(function ($dokumenPersyaratan) {
            $dokumenUkomDto = DocumentUkomConverter::dokumenPersyaratanToDto($dokumenPersyaratan);
            $dokumenUkomDto->jenis_ukom = $dokumenPersyaratan->additional_1;
            $dokumenUkomDto->jabatan_code = $dokumenPersyaratan->additional_2 ?? null;
            $dokumenUkomDto->jenjang_code = $dokumenPersyaratan->additional_3 ?? null;
            $dokumenUkomDto->is_mengulang = $dokumenPersyaratan->additional_4 == "true" ?? null;
            if ($dokumenUkomDto->jabatan_code) {
                $dokumenUkomDto->jabatan_name = $this->jabatanService->findByCode($dokumenUkomDto->jabatan_code)->name;
            }
            if ($dokumenUkomDto->jenjang_code) {
                $dokumenUkomDto->jenjang_name = $this->jenjangService->findByCode($dokumenUkomDto->jenjang_code)->name;
            }
            return $dokumenUkomDto;
        });
    }

    public function findAllByJenisUkom($jenis_ukom, $jabatan_code = null, $jenjang_code = null, $is_mengulang = null)
    {
        return $this->dokumenPersyaratanService->findByAssociationAndAdditionals("ukm_participant", [
            'additional_1' => $jenis_ukom,
            'additional_2' => $jabatan_code,
            'additional_3' => $jenjang_code,
            'additional_4' => $is_mengulang,
        ])->map(function ($dokumenPersyaratan) {
            $dokumenUkomDto = DocumentUkomConverter::dokumenPersyaratanToDto($dokumenPersyaratan);
            $dokumenUkomDto->jenis_ukom = $dokumenPersyaratan->additional_1;
            $dokumenUkomDto->jabatan_code = $dokumenPersyaratan->additional_2 ?? null;
            $dokumenUkomDto->jenjang_code = $dokumenPersyaratan->additional_3 ?? null;
            $dokumenUkomDto->is_mengulang = $dokumenPersyaratan->additional_4 == "true" ?? null;
            if ($dokumenUkomDto->jabatan_code) {
                $dokumenUkomDto->jabatan_name = $this->jabatanService->findByCode($dokumenUkomDto->jabatan_code)->name;
            }
            if ($dokumenUkomDto->jenjang_code) {
                $dokumenUkomDto->jenjang_name = $this->jenjangService->findByCode($dokumenUkomDto->jenjang_code)->name;
            }
            return $dokumenUkomDto;
        });
    }

    public function findAllByParticipantUkomId($participant_ukom_id)
    {
        return DocumentUkom::where("participant_ukom_id", $participant_ukom_id)->get()->map(function ($formasiDokumen) {
            $formasiDokumenDto = DocumentUkomConverter::toDto($formasiDokumen);
            $formasiDokumenDto->dokumen_url = $this->storageService->getUrl("system", "ukom", $formasiDokumen->dokumen);
            return $formasiDokumenDto;
        });
    }

    public function save(ParticipantUkomDto $participantUkomDto)
    {
        return DB::transaction(function () use ($participantUkomDto) {
            if (!in_array($participantUkomDto->jenis_ukom, [JenisUkom::KENAIKAN_JENJANG->value, JenisUkom::PERPINDAHAN_JABATAN->value, JenisUkom::PROMOSI->value])) {
                throw new RecordNotFoundException("jenis_ukom not found", ["jenis_ukom" => $participantUkomDto->jenis_ukom]);
            }

            foreach ($participantUkomDto->dokumen_ukom_list as $key => $dokumen_ukom) {
                $documentUkomDto = (new DocumentUkomDto())->fromArray((array) $dokumen_ukom);

                $documentUkom = new DocumentUkom();
                $documentUkom->fromArray($documentUkomDto->toArray());
                $documentUkom->participant_ukom_id = $participantUkomDto->id;
                $documentUkom->dokumen_name = $documentUkomDto->dokumen_persyaratan_name;
                $documentUkom->jenis_ukom = $participantUkomDto->jenis_ukom;

                $documentUkom->save();
            }
        });
    }

    public function saveDokumen(DocumentUkomDto $documentUkomDto)
    {
        return DB::transaction(function () use ($documentUkomDto) {
            $dokumenPersyaratanDto = new DokumenPersyaratanDto();
            $dokumenPersyaratanDto->name = $documentUkomDto->dokumen_persyaratan_name;
            $dokumenPersyaratanDto->association = "ukm_participant";
            $dokumenPersyaratanDto->additional_1 = $documentUkomDto->jenis_ukom;
            $dokumenPersyaratanDto->additional_2 = $documentUkomDto->jabatan_code;
            $dokumenPersyaratanDto->additional_3 = $documentUkomDto->jenjang_code;
            $dokumenPersyaratanDto->additional_4 = $documentUkomDto->is_mengulang ? "true" : "false";

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
