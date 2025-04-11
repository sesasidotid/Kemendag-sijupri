<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Exceptions\ValidationException;
use Eyegil\Base\Pageable;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\SijupriAkp\Converters\AkpConverters;
use Eyegil\SijupriAkp\Dtos\AkpDto;
use Eyegil\SijupriAkp\Services\AkpService;
use Eyegil\StorageBase\Services\StorageService;
use Illuminate\Http\Request;

#[Controller("/api/v1/akp")]
class AkpController
{
    public function __construct(
        private AkpService $akpService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $akpSearch = $this->akpService->findSearch(new Pageable($request->query()));
        return $akpSearch->setCollection($akpSearch->getCollection()->map(function ($akp) {
            $akpDto = (new AkpDto())->fromModel($akp);
            $akpDto->instrument_name = optional($akp->instrument)->name;

            return $akpDto;
        }));
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return AkpConverters::toDto($this->akpService->findById($id), $this->storageService);
    }

    #[Get("/reviewer/{reviewer}/{id}")]
    public function getAkpForReviewer(Request $request)
    {
        return $this->akpService->getAkpForReviewer($request->reviewer, $request->id);
    }

    #[Get("/personal/{id}")]
    public function getAkpForPersonal($id)
    {
        return $this->akpService->getAkpForPersonal($id);
    }

    #[Post("/notify")]
    public function notifyAtasan(Request $request)
    {
        $notificationDto = NotificationDto::fromRequest($request);
        $notificationDto->validate(["to" => "required", "object_map" => "required"]);
        if (!$notificationDto->objectMap['nama_atasan'] || !$notificationDto->objectMap['akp_id']) {
            throw new ValidationException(NotificationDto::class);
        }
        $this->akpService->sendNotifyAtasan($notificationDto);
    }

    #[Post("/matrix/atasan")]
    public function saveMatrixAtasan(Request $request)
    {
        $akpDto = AkpDto::fromRequest($request);
        return $this->akpService->saveMatrixAtasan($akpDto);
    }

    #[Post("/matrix/rekan")]
    public function saveMatrixRekan(Request $request)
    {
        $akpDto = AkpDto::fromRequest($request);
        return $this->akpService->saveMatrixRekan($akpDto);
    }

    #[Post("/matrix/personal")]
    public function saveMatrixYbs(Request $request)
    {
        $akpDto = AkpDto::fromRequest($request);
        return $this->akpService->saveMatrixYbs($akpDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->akpService->delete($id);
    }
}
