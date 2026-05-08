<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\SijupriUkom\Dtos\ExamScheduleCatDto;
use Eyegil\SijupriUkom\Dtos\ExamSchedulePortofolioDto;
use Eyegil\SijupriUkom\Dtos\ExamSchedulePraktikDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleSeminarMakalahDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleStudiKasusDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleUpdateDto;
use Eyegil\SijupriUkom\Dtos\ExamScheduleWawancaraDto;
use Eyegil\SijupriUkom\Dtos\UpdateAssignerExaminer;
use Eyegil\SijupriUkom\Dtos\UpdateAssignerParticipant;
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_schedule")]
class ExamScheduleController
{
    public function __construct(
        private ExamScheduleService $examScheduleService,
    ) {
    }

    #[Get("/testing_aja")]
    public function testing_aja()
    {
        // UkomGradeJob::dispatch();
        // $this->examScheduleService->generateSchedule();
    }

    #[Get("/calendar")]
    public function calendar(Request $request)
    {
        return $this->examScheduleService->calendar($request->query());
    }

    #[Get("/room/{room_id}")]
    public function findByRoomId($room_id)
    {
        return $this->examScheduleService->findAllByRoomUkomId($room_id);
    }

    #[Get("/detail/{id}")]
    public function findDetailById($id)
    {
        return $this->examScheduleService->findDetailById($id);
    }

    #[Get("/participant/{participant_id}")]
    public function findByParticipantId($participant_id)
    {
        return $this->examScheduleService->findByParticipantId($participant_id);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->examScheduleService->delete($id);
    }


    //-------------------------


    #[Get("/participant_schedule/{exam_schedule_id}")]
    public function findParticipantScheduleByExamScheduleId($exam_schedule_id)
    {
        return $this->examScheduleService->findParticipantScheduleByExamScheduleId($exam_schedule_id);
    }

    #[Get("/examiner_schedule/{exam_schedule_id}")]
    public function findExaminerScheduleByExamScheduleId($exam_schedule_id)
    {
        return $this->examScheduleService->findExaminerScheduleByExamScheduleId($exam_schedule_id);
    }

    #[Get("/examiner/{examiner_id}")]
    public function findByExaminerId($examiner_id)
    {
        return $this->examScheduleService->findByExaminerId($examiner_id);
    }

    #[Put("/participant_schedule/{participant_schedule_id}")]
    public function updateAssignerParticipantSchedule(Request $request)
    {
        $updateAssignerParticipant = new UpdateAssignerParticipant();
        $updateAssignerParticipant->participant_schedule_id = $request->route('participant_schedule_id');
        $updateAssignerParticipant->personal_schedule = $request->get('personal_schedule');
        return $this->examScheduleService->updateAssignerParticipantSchedule($updateAssignerParticipant);
    }

    #[Put("/examiner_schedule")]
    public function updateAssignedExaminerSchedule(Request $request)
    {
        $updateAssignerExaminer = UpdateAssignerExaminer::fromRequest($request);
        return $this->examScheduleService->updateAssignedExaminerSchedule($updateAssignerExaminer);
    }


    #[Post("/cat")]
    public function saveCat(Request $request)
    {
        $examScheduleCatDto = ExamScheduleCatDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->saveCat($examScheduleCatDto);
    }

    #[Post("/makalah")]
    public function saveSeminarMakalah(Request $request)
    {
        $examScheduleSeminarMakalah = ExamScheduleSeminarMakalahDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->saveSeminarMakalah($examScheduleSeminarMakalah);
    }

    #[Post("/wawancara")]
    public function saveWawancara(Request $request)
    {
        $examScheduleWawancaraDto = ExamScheduleWawancaraDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->saveWawancara($examScheduleWawancaraDto);
    }

    #[Post("/praktik")]
    public function savePraktik(Request $request)
    {
        $examSchedulePraktikDto = ExamSchedulePraktikDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->savePraktik($examSchedulePraktikDto);
    }

    #[Post("/portofolio")]
    public function savePortofolio(Request $request)
    {
        $examSchedulePortofolioDto = ExamSchedulePortofolioDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->savePortofolio($examSchedulePortofolioDto);
    }

    #[Post("/studi_kasus")]
    public function saveStudiKasus(Request $request)
    {
        $examScheduleStudiKasusDto = ExamScheduleStudiKasusDto::fromRequest($request)->validateSave();
        return $this->examScheduleService->saveStudiKasus($examScheduleStudiKasusDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $examScheduleUpdateDto = ExamScheduleUpdateDto::fromRequest($request)->validateUpdate();
        return $this->examScheduleService->update($examScheduleUpdateDto);
    }
}
