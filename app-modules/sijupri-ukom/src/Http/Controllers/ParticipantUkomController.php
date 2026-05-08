<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Converters\ParticipantUkomConverter;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/participant_ukom")]
class ParticipantUkomController
{
    public function __construct(
        private ParticipantUkomService $participantUkomService,
        private StorageService $storageService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->participantUkomService->findSearch(new Pageable(array_map('strtolower', $request->query())));
    }

    #[Get("/search/{nip}")]
    public function findSearchByNip(Request $request)
    {
        return $this->participantUkomService->findSearchByNip(new Pageable(array_map('strtolower', $request->query())), $request->nip);
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        $participantUkom = ParticipantUkomConverter::withRoomOrBanPersonal($this->participantUkomService->findById($id));
        if ($participantUkom->rekomendasi) {
            $participantUkom->rekomendasi_url = $this->storageService->getUrl("system", "ukom", $participantUkom->rekomendasi);
        }
        return $participantUkom;
    }

    #[Get("/nip/{nip}")]
    public function findByNip($id)
    {
        return ParticipantUkomConverter::withRoomOrBanPersonal($this->participantUkomService->findLatestByNip($id));
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

    #[Get("/email_id/{email_id}")]
    public function findByNipOrEmail($email_id)
    {
        return $this->participantUkomService->findByNipOrEmail($email_id);
    }

    #[Post("/upload_rekomendasi")]
    public function uploadRekomendasiUkom(Request $request)
    {
        $roomUkomDto = ParticipantUkomDto::fromRequest($request)->validateUploadRekomendasi();
        $this->participantUkomService->uploadRekomendasiUkom($roomUkomDto);
    }

    #[Post("/upload_rekomendasi/batch")]
    public function uploadRekomendasiUkomBatch(Request $request)
    {
        $request->validate([
            "compressed_file" => "required",
        ]);
        $this->participantUkomService->uploadRekomendasiUkomBatch($request->compressed_file);
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
