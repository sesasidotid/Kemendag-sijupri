<?php

namespace Eyegil\SijupriFormasi\Services;

use Error;
use Eyegil\SijupriFormasi\Dtos\FormasiResultDto;
use Eyegil\SijupriFormasi\Models\FormasiResult;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FormasiResultService
{

    public function findById($id): FormasiResult
    {
        return FormasiResult::findOrThrowNotFound($id);
    }

    public function save(FormasiResultDto $formasiResultDto)
    {
        return  DB::transaction(function () use ($formasiResultDto) {
            $userContext = user_context();

            $formasiResult = new FormasiResult();
            $formasiResult->fromArray($formasiResultDto->toArray());
            $formasiResult->created_by = $userContext->id;
            $formasiResult->saveWithUUid();

            return $formasiResult;
        });
    }

    public function update(FormasiResultDto $formasiResultDto): FormasiResult
    {
        return  DB::transaction(function () use ($formasiResultDto): FormasiResult {
            $userContext = user_context();

            $formasiResult = $this->findById($formasiResultDto->id);
            $formasiResult->result = (int) $formasiResultDto->result ?? (int) $formasiResult->pembulatan ?? 0;
            $formasiResult->created_by = $userContext->id;
            $formasiResult->save();

            return $formasiResult;
        });
    }
}
