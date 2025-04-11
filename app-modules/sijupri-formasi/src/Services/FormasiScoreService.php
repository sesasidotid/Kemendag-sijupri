<?php

namespace Eyegil\SijupriFormasi\Services;

use Eyegil\SijupriFormasi\Dtos\FormasiScoreDto;
use Eyegil\SijupriFormasi\Models\FormasiScore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiScoreService
{

    public function findById($id)
    {
        return FormasiScore::findOrThrowNotFound($id);
    }

    public function findByUnsurIdAndFormasiDetailId($unsur_id, $formasi_detail_id)
    {
        return FormasiScore::where("unsur_id", $unsur_id)->where("formasi_detail_id", $formasi_detail_id)->first();
    }

    public function save(FormasiScoreDto $formasiScoreDto) {
        return  DB::transaction(function () use ($formasiScoreDto) {
            $userContext = user_context();

            $formasi = new FormasiScore();
            $formasi->fromArray($formasiScoreDto->toArray());
            $formasi->created_by = $userContext->id;
            $formasi->saveWithUUid();

            return $formasi;
        });
    }
}
