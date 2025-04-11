<?php

namespace App\Http\Middleware;

use Closure;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordNotFoundException;
use Eyegil\SecurityBase\Dtos\DeviceDto;
use Eyegil\SecurityBase\Services\DeviceService;
use Eyegil\NotificationFirebase\Services\FirebaseMessageTokenService;
use Eyegil\NotificationFirebase\Services\NotificationFirebaseService;
use Eyegil\SecurityBase\Services\IAuthenticationFilterService;
use Eyegil\SecurityBase\Services\UserApplicationChannelService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SijupriSiap\Models\JF;
use Eyegil\SijupriSiap\Models\UserInstansi;
use Eyegil\SijupriSiap\Models\UserUnitKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RefreshMobileAuthenticationFilterMiddleware implements IAuthenticationFilterService
{
    public function __construct(
        private DeviceService $deviceService,
        private FirebaseMessageTokenService $firebaseMessageTokenService,
        private NotificationFirebaseService $notificationFirebaseService,
        private UserApplicationChannelService $userApplicationChannelService,
        private UserAuthenticationService $userAuthenticationService,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $this->verifyCaptcha($request);

        $userApplicationChannelList = $this->userApplicationChannelService->findByUserIdAndChannelCode($request['username'], $request['channel_code']);
        if (!$userApplicationChannelList || count($userApplicationChannelList) == 0) throw new RecordNotFoundException("User not found");
        $userApplicationChannel = $userApplicationChannelList->get(0);
        $request->merge(['application_code' => $userApplicationChannel->application_code]);

        if ($request["application_code"] != "sijupri-internal" && $request["application_code"] != "sijupri-external") {
            throw new BusinessException("Unauthorized", "AUTH");
        }

        $loginContext = $this->userAuthenticationService->refreshLogin($request['username'], $request['application_code']);

        $instansiId = null;
        $unitKerjaId = null;
        switch ($request['application_code']) {
            case 'sijupri-instansi':
                $userInstansi = UserInstansi::find($request['username']);
                $instansiId = $userInstansi->instansi_id;
                break;
            case 'sijupri-unit-kerja':
                $userUnitKerja = UserUnitKerja::find($request['username']);
                $unitKerjaId = $userUnitKerja->unit_kerja_id;
                $instansiId = $userUnitKerja->unitKerja->instansi_id;
                break;
            case 'sijupri-internal':
                $jf = JF::find($request['username']);
                $unitKerjaId = $jf->unit_kerja_id;
                $instansiId = $jf->unitKerja->instansi_id;
                break;
            case 'sijupri-external':
                $jf = JF::find($request['username']);
                $unitKerjaId = $jf->unit_kerja_id;
                $instansiId = $jf->unitKerja->instansi_id;
                break;
            default:
                break;
        }

        $request->attributes->set('user_id', $loginContext->user_id);
        $request->attributes->set('details', [
            "id" => $loginContext->user_id,
            "name" => $loginContext->name,
            "role_codes" => $loginContext->role_codes,
            "menu_codes" => $loginContext->menu_codes,
            "application_code" => $request['application_code'],
            "instansi_id" => $instansiId,
            "unit_kerja_id" => $unitKerjaId,
            "urls" => $loginContext->urls,
        ]);
        $request->merge([
            "user_id" => $loginContext->user_id,
            "details" => [
                "user_id" => $loginContext->user_id,
                "application_code" => $request['application_code'],
                "instansi_id" => $instansiId,
                "unit_kerja_id" => $unitKerjaId,
                "menus" => $loginContext->menus,
                "name" => $loginContext->name,
                "role_codes" => $loginContext->role_codes,
                "menu_codes" => $loginContext->menu_codes,
            ],
        ]);

        DB::transaction(function () use ($request) {
            $deviceDto = DeviceDto::fromRequest($request);
            $deviceDto->id = $request['device_id'];
            $deviceDto->user_id = $request['username'];
            $device = $this->deviceService->findById($deviceDto->id);
            if (!$device) {
                $device = $this->deviceService->save($deviceDto);
            } else {
                $device = $this->deviceService->update($deviceDto);
            }
        });

        return $next($request);
    }

    private function verifyCaptcha(Request $request)
    {
        $isCaptchaEnable = config("eyegil.captcha.enable", false);
        if (!$isCaptchaEnable) return;

        if (!isset($request['captcha_token'])) {
            throw new BusinessException("Invalid Request", "AUTH");
        }

        $secretKey = config("eyegil.captcha.secretKey");
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $request['captcha_token']
        ]);

        $captchaResponse = $response->json();
        if (!isset($captchaResponse['success']) || !$captchaResponse['success']) {
            throw new BusinessException("Invalid CAPTCHA", "AUTH");
        }
    }
}
