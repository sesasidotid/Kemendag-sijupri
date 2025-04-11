<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Converters\ParticipantUkomConverter;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Illuminate\Http\Request;

#[Controller("/api/v1/participant_ukom")]
class ParticipantUkomController
{
    public function __construct(
        private ParticipantUkomService $participantUkomService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->participantUkomService->findSearch(new Pageable($request->query()));
    }

    #[Get("/search/{nip}")]
    public function findSearchByNip(Request $request)
    {
        return $this->participantUkomService->findSearchByNip(new Pageable($request->query()), $request->nip);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return ParticipantUkomConverter::toDto($this->participantUkomService->findById($id));
    }

    #[Get("/nip/{nip}")]
    public function findByNip($id)
    {
        return ParticipantUkomConverter::withRoomOrBan($this->participantUkomService->findLatestByNip($id));
    }

    #[Get("/room/{room_id}")]
    public function findByRoomId($room_id)
    {
        return $this->participantUkomService->findByRoomId($room_id);
    }

    #[Get("/all/{nip}")]
    public function findAllByNip(Request $request)
    {
        return $this->participantUkomService->findAllByNip($request->nip);
    }

    #[Get("latest/{nip}")]
    public function findLatestByNip(Request $request)
    {
        return ParticipantUkomConverter::toDto($this->participantUkomService->findLatestByNip($request->nip));
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->participantUkomService->delete($id);
    }

    #[Delete("/delete/{nip}")]
    public function deleteByNip($nip)
    {
        return $this->participantUkomService->deleteByNip($nip);
    }
}
