<?php

namespace Eyegil\SijupriSecurity\Http\Controllers;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SijupriAuthController
{
    public function __construct(
        private UserService $userService,
        private UserAuthenticationService $userAuthenticationService
    ) {}

    public function view_login()
    {
        return view('sijupri-security::auth.login');
    }

    public function post_authenticate(Request $request)
    {
        if (!$this->verifyCaptcha($request)->json()['success']) {
            return redirect()->back()->withInput()->withErrors(['captcha' => 'Please verify that you are not a robot.']);
        }

        $loginContext = $this->userAuthenticationService->login("password", $request->nip, $request->password);
        if ($loginContext->status) {
            $user = $this->userService->findById($loginContext->user_id);
            Auth::login($user);
            Log::info("IS LOGED IN");
            return redirect()->route('dashboard');
        } else {
            throw new BusinessException("User Status Tidak Ditemukan", "SEC-000002");
        }
    }

    private function verifyCaptcha($request)
    {
        return Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('CAPTCHA_SECRET_KEY', ''),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    }
}
