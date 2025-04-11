<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use App\Enums\NotificationTemplateCode;
use Carbon\Carbon;
use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\NotificationBase\Dtos\NotificationDto;
use Eyegil\NotificationBase\Services\NotificationService;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Illuminate\Http\Request;

#[Controller("/api/v1/forgot_password")]
class ForgotPasswordController
{
    public function __construct(
        private UserService $userService,
        private NotificationService $notificationService,
    ) {}

    #[Post()]
    public function forgotPassword(Request $request)
    {
        $request->validate(["user_id" => "required"]);
        $user = $this->userService->findByIdv2($request->user_id);
        if ($user) {
            $sysConfig = SystemConfiguration::find("URL_CHANGE_PASSWORD");
            $expiredTime = (int) optional($sysConfig)->value ?? 10;;

            $currentDate = Carbon::now();
            if ($expiredTime > 0) {
                $encriptionKey = EncriptionKey::builder(["user_id" => $request->user_id])
                    ->validFrom($currentDate->toString())
                    ->validTo($currentDate->copy()->addMinutes($expiredTime)->toString())
                    ->accessAmount(1)
                    ->generate();
            } else {
                $encriptionKey = EncriptionKey::builder(["user_id" => $request->user_id])
                    ->validFrom($currentDate->toString())
                    ->accessAmount(1)
                    ->generate();
            }

            $page_url = config("eyegil.client_url") . '/forgot_password?key=' . $encriptionKey->getKey();

            $notificationDto = new NotificationDto();
            $notificationDto->subject = "Lupa Password";
            $notificationDto->objectMap = [
                "name" => $user->name,
                "page_url" => $page_url,
            ];

            $this->notificationService->sendTo("smtp", [$user->email], NotificationTemplateCode::FORGOT_PASSWORD->value, $notificationDto);
        }
    }
}
