<?php

namespace Eyegil\NotificationFirebase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\NotificationFirebase\Services\FirebaseTokenHandlerService;
use Eyegil\NotificationFirebase\Dtos\FcmTokenDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

#[Controller("/api/v1/fcm_token")]
class FirebaseMessageTokenController
{
    public function __construct(
        private FirebaseTokenHandlerService $firebaseTokenHandlerService
    ) {}

    #[Put()]
    public function createOrUpdate(Request $request)
    {
        $fcmTokenDto = FcmTokenDto::fromRequest($request)->validateUpdate();
        return $this->firebaseTokenHandlerService->createOrUpdate($fcmTokenDto);
    }
}
