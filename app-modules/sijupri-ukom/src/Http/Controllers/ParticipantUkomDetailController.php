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
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\SijupriUkom\Services\ParticipantUkomTaskService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Enums\TaskStatus;
use Illuminate\Http\Request;

#[Controller("/api/v1/participant_ukom_detail")]
class ParticipantUkomDetailController
{
    public function __construct(
        private ParticipantUkomTaskService $participantUkomTaskService,
        private ParticipantUkomService $participantUkomService,
        private ExamGradeService $examGradeService,
        private DocumentUkomService $documentUkomService,
        private StorageService $storageService,
        private ExamScheduleService $examScheduleService,
    ) {
    }

    #[Get()]
    public function getByKey(Request $request)
    {
        if (!$request->query->has('key'))
            throw new BusinessException("Parameter Key not found", "UKM-00004");
        $encriptionKey = new EncriptionKey($request->query("key"));

        $data = $encriptionKey->validate();
        if (!$data)
            throw new BusinessException("key not valid", "PASS-00001");
        $participant_ukom_id = $data->participant_ukom_id;

        $documentUkomList = $this->documentUkomService->findAllByParticipantUkomId($participant_ukom_id);
        try {
            $participantUkomPendingTaskDto = $this->participantUkomTaskService->findByParticipantUkomId($participant_ukom_id);

            return [
                "status" => ($participantUkomPendingTaskDto->task_status == TaskStatus::PENDING->value) ? "pending" : "failed",
                "data" => $participantUkomPendingTaskDto
            ];
        } catch (\Throwable $th) {
            $participantUkomDto = ParticipantUkomConverter::toDto($this->participantUkomService->findById($participant_ukom_id))->toArray();
            $participantUkomDto["grades"] = [];
            $participantUkomDto['document_ukom_list'] = $documentUkomList;
            try {
                $participantUkomDto["grades"]["cat"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::CAT->value, $participant_ukom_id);
                $participantUkomDto["grades"]["wawancara"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::WAWANCARA->value, $participant_ukom_id);
                $participantUkomDto["grades"]["portofolio"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::PORTOFOLIO->value, $participant_ukom_id);
                $participantUkomDto["grades"]["studi_kasus"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::STUDI_KASUS->value, $participant_ukom_id);
                $participantUkomDto["grades"]["makalah"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::MAKALAH->value, $participant_ukom_id);
                $participantUkomDto["grades"]["seminar"] = $this->examGradeService->findGradeByExamTypeCodeAndParticipantIdLatest(ExamTypes::SEMINAR->value, $participant_ukom_id);
            } catch (\Throwable $ignored) {
                $participantUkomDto["grades"]["cat"] = null;
                $participantUkomDto["grades"]["wawancara"] = null;
                $participantUkomDto["grades"]["portofolio"] = null;
                $participantUkomDto["grades"]["studi_kasus"] = null;
                $participantUkomDto["grades"]["makalah"] = null;
                $participantUkomDto["grades"]["seminar"] = null;
            }
            try {
                $participantUkomDto["rekomendasi_url"] = $this->storageService->getUrl("system", "ukom", $participantUkomDto["rekomendasi"]);
            } catch (\Throwable $ignored) {
                $participantUkomDto["rekomendasi_url"] = null;
            }

            $participantUkomDto["exam_schedule"] = $this->examScheduleService->findByParticipantId($participant_ukom_id);


            return [
                "status" => "finish",
                "data" => $participantUkomDto
            ];
        }
    }
}
