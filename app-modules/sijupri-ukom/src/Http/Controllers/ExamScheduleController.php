<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriUkom\Dtos\RoomUkomDto;
use Eyegil\SijupriUkom\Services\ExamScheduleService;
use Illuminate\Http\Request;

#[Controller("/api/v1/exam_schedule")]
class ExamScheduleController
{
    public function __construct(
        private ExamScheduleService $examScheduleService,
    ) {}

    #[Get("/room/{room_id}")]
    public function findByRoomId($room_id)
    {
        return $this->examScheduleService->findAllByRoomUkomId($room_id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $examSchedule = RoomUkomDto::fromRequest($request)->validateSaveSchedule();
        return $this->examScheduleService->save($examSchedule);
    }
}
