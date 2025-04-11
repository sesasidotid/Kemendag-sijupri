<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Converters\RoomUkomConverter;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Dtos\RoomUkomQuestionDto;
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Eyegil\SijupriUkom\Services\RoomUkomService;
use Illuminate\Http\Request;

#[Controller("/api/v1/room_ukom")]
class RoomUkomController
{
    public function __construct(
        private RoomUkomService $roomUkomService,
        private ExamScheduleService $examScheduleService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->roomUkomService->findSearch(new Pageable($request->query()));
    }

    #[Post("/search/{exam_type_code}/{room_ukom_id}")]
    public function findQuestionSearch(Request $request)
    {
        return $this->roomUkomService->findQuestionSearch(new Pageable($request->query()), $request->exam_type_code, $request->room_ukom_id);
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return RoomUkomConverter::toDto($this->roomUkomService->findById($request->id));
    }

    #[Post("/schedule")]
    public function saveExamSchedule(Request $request)
    {
        $roomUkomDto = RoomUkomDto::fromRequest($request)->validateSaveSchedule();
        return $this->examScheduleService->save($roomUkomDto);
    }

    #[Post()]
    public function save(Request $request)
    {
        $roomUkomDto = RoomUkomDto::fromRequest($request)->validateSave();
        return $this->roomUkomService->save($roomUkomDto);
    }

    #[Post("/question")]
    public function setQuestion(Request $request)
    {
        $roomUkomDto = RoomUkomQuestionDto::fromRequest($request)->validateSave();
        return $this->roomUkomService->setQuestion($roomUkomDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $roomUkomDto = RoomUkomDto::fromRequest($request)->validateUpdate();
        return $this->roomUkomService->update($roomUkomDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->roomUkomService->delete($id);
    }
}
