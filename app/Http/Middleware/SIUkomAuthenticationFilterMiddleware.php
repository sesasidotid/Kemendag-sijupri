<?php

namespace App\Http\Middleware;

use Closure;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityBase\Services\IAuthenticationFilterService;
use Eyegil\SecurityBase\Services\UserApplicationChannelService;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SIUkomAuthenticationFilterMiddleware implements IAuthenticationFilterService
{
    public function __construct(
        private UserApplicationChannelService $userApplicationChannelService,
        private UserAuthenticationService $userAuthenticationService,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $this->verifyCaptcha($request);

        if ($request['client_id'] == "siukom-participant") {
            $request->merge(['username' => "PU-" . $request['username']]);
        } else if ($request['client_id'] == "siukom-examiner") {
            $request->merge(['username' => "EU-" . $request['username']]);
        } else {
            throw new BusinessException("Invalid Client Id", "");
        }

        $userApplicationChannelList = $this->userApplicationChannelService->findByUserIdAndChannelCode($request['username'], $request['channel_code']);
        if (!$userApplicationChannelList || count($userApplicationChannelList) == 0) throw new RecordNotFoundException("User not found");
        $userApplicationChannel = $userApplicationChannelList->get(0);
        $request->merge(['application_code' => $userApplicationChannel->application_code]);

        $loginContext = $this->userAuthenticationService->login($request['username'], $request["password"], $request['application_code'], "password");

        $participant_id = null;
        switch ($request['application_code']) {
            case 'siukom-participant':
                $participant = ParticipantUkom::where('user_id', $request['username'])
                    ->where('inactive_flag', false)
                    ->where('delete_flag', false)
                    ->latest("date_created")
                    ->first();

                if (!$participant) {
                    throw new RecordNotFoundException("participant not exist");
                }

                $participant_id = $participant->id;

                break;
            case 'siukom-examiner':
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
            "participant_id" => $participant_id,
            "urls" => $loginContext->urls,
        ]);
        $request->merge([
            "user_id" => $loginContext->user_id,
            "details" => [
                "user_id" => $loginContext->user_id,
                "application_code" => $request['application_code'],
                "participant_id" => $participant_id,
                "menus" => $loginContext->menus,
                "name" => $loginContext->name,
                "role_codes" => $loginContext->role_codes,
                "menu_codes" => $loginContext->menu_codes,
            ],
        ]);

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
