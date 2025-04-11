<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriFormasi\Dtos\FormasiProsesVerifikasiDto;
use Eyegil\SijupriFormasi\Models\FormasiProsesVerifikasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiProsesVerifikasiService
{

    public function findById($id)
    {
        return FormasiProsesVerifikasi::findOrThrowNotFound($id);
    }

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();

        if ($userContext->application_code == "sijupri-unit-kerja") {
            $pageable->addEqual("formasi|unit_kerja_id", $userContext->getDetails("unit_kerja_id"));
        }
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(FormasiProsesVerifikasi::class, ["formasi"]);
    }

    public function save(FormasiProsesVerifikasiDto $formasiProsesVerifikasiDto)
    {
        return DB::transaction(function () use ($formasiProsesVerifikasiDto) {
            $userContext = user_context();

            $formasiDokumen = new FormasiProsesVerifikasi();
            $formasiDokumen->fromArray($formasiProsesVerifikasiDto->toArray());
            $formasiDokumen->created_by = $userContext->id;
            $formasiDokumen->saveWithUUid();
        });
    }
}
