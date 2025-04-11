<?php

namespace Eyegil\SijupriAkp\Services;

use Carbon\Carbon;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SijupriAkp\Dtos\AkpRekapDto;
use Eyegil\SijupriAkp\Enums\AkpRekapVerified;
use Eyegil\SijupriAkp\Models\AkpRekap;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AkpRekapService
{

    public function __construct(
        private StorageService $storageService,
        private StorageSystemService $storageSystemService
    ) {}

    public function findAllByVerifiedFalse()
    {
        return AkpRekap::where("verified", false)->get();
    }

    public function findById($id): AkpRekap
    {
        return AkpRekap::findOrThrowNotFound($id);
    }

    public function findByMatrixId($matrix_id)
    {
        return AkpRekap::where("matrix_id", $matrix_id)->first();
    }

    public function save(AkpRekapDto $akpRekapDto)
    {
        return DB::transaction(function () use ($akpRekapDto) {
            $akpRekap = new AkpRekap();
            $akpRekap->fromArray($akpRekapDto->toArray());
            $akpRekap->save();

            return $akpRekap;
        });
    }

    public function uploadKompetensionProof(AkpRekapDto $akpRekapDto)
    {
        return DB::transaction(function () use ($akpRekapDto) {
            $userContext = user_context();

            $akpRekap = $this->findById($akpRekapDto->id);
            $akpRekap->dokumen_verifikasi = $this->storageService->putObjectFromBase64WithFilename("system", "akp", "sk_rekap_" . Carbon::now()->format('YmdHis'), $akpRekapDto->file_dokumen_verifikasi);
            $akpRekap->verified = AkpRekapVerified::PENDING->value;
            $akpRekap->updated_by = $userContext->id;
            $akpRekap->save();
        });
    }

    public function validateDokumenVerifikasi(AkpRekapDto $akpRekapDto)
    {
        return DB::transaction(function () use ($akpRekapDto) {
            $userContext = user_context();

            $akpRekap = $this->findById($akpRekapDto->id);
            if ($akpRekap->verified != AkpRekapVerified::PENDING->value) {
                throw new BusinessException("document is not pending to verify", "");
            }
            if ($akpRekapDto->verified != AkpRekapVerified::REJECT->value && $akpRekapDto->verified != AkpRekapVerified::APPROVE->value) {
                throw new BusinessException("not allowed verified type", "");
            }
            $akpRekap->verified = $akpRekapDto->verified;
            $akpRekap->updated_by = $userContext->id;
            $akpRekap->remark = $akpRekapDto->remark;
            $akpRekap->save();
        });
    }

    public function downloadTemplate()
    {
        return $this->storageSystemService->downloadFile("template", "template_validate_akp_pelatihan.xlsx");
    }

    public function validatePelatihan($file_dokumen_verifikasi)
    {
        return DB::transaction(function () use ($file_dokumen_verifikasi) {
            $object_name = $this->storageService->putObjectFromBase64WithFilename("system", "akp", "pelatihan_teknis_" . Carbon::now()->format('YmdHis'), $file_dokumen_verifikasi);
            $file_location = $this->storageSystemService->getFileLocation("akp", $object_name);

            $spreadsheet = IOFactory::load(storage_path('app/' . $file_location));
            $sheet = $spreadsheet->getActiveSheet();
            $data = [];

            foreach ($sheet->getRowIterator() as $row) {
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            foreach ($data as $key => $value) {
                if ($key == 0) continue;

                if (strtolower(trim($value[3])) == "masuk") {
                    AkpRekap::whereNot("verified", AkpRekapVerified::APPROVE->value)->whereHas('pelatihanTeknis', function ($query) use ($value) {
                        $query->where('code', trim($value[0]));
                    })->whereHas('matrix.akp', function ($query_akp) use ($value) {
                        $query_akp->where('nip', trim($value[2]));
                    })->update([
                        "verified" => AkpRekapVerified::APPROVE->value,
                        "dokumen_verifikasi" => $object_name
                    ]);
                }
            }
        });
    }
}
