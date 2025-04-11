<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SijupriUkom\Converters\ParticipantUkomConverter;
use Eyegil\SijupriUkom\Enums\ExamTypes;
use Eyegil\SijupriUkom\Services\DocumentUkomService;
use Eyegil\SijupriUkom\Services\ExamGradeService;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\SijupriUkom\Services\ParticipantUkomTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/participant_ukom_detail")]
class ParticipantUkomDetailController
{
    public function __construct(
        private ParticipantUkomTaskService $participantUkomTaskService,
        private ParticipantUkomService $participantUkomService,
        private ExamGradeService $examGradeService,
        private DocumentUkomService $documentUkomService,
    ) {}

    #[Get()]
    public function getByKey(Request $request)
    {
        if (!$request->query->has('key')) throw new BusinessException("Parameter Key not found", "UKM-00004");
        $encriptionKey = new EncriptionKey($request->query("key"));
        
        $data = $encriptionKey->validate();
        if(!$data) throw new BusinessException("key not valid", "PASS-00001");
        $participant_ukom_id = $data->participant_ukom_id;

        $documentUkomList = $this->documentUkomService->findAllByParticipantUkomId($participant_ukom_id);
        try {
            return [
                "status" => "pending",
                "data" => $this->participantUkomTaskService->findByParticipantUkomId($participant_ukom_id)
            ];
        } catch (\Throwable $th) {
            $participantUkomDto = ParticipantUkomConverter::toDto($this->participantUkomService->findById($participant_ukom_id))->toArray();
            $participantUkomDto["grades"] = [];
            $participantUkomDto['document_ukom_list'] = $documentUkomList;
            try {
                $participantUkomDto["grades"]["cat"] = $this->examGradeService->findByExamTypeCodeAndParticipantId(ExamTypes::CAT->value, $participant_ukom_id);
            } catch (\Throwable $ignored) {
                $participantUkomDto["grades"]["cat"] = null;
            }

            return [
                "status" => "finish",
                "data" => $participantUkomDto
            ];
        }
    }
}
