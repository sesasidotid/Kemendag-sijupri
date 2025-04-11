<?php

namespace Eyegil\SecurityPassword\Http\Controllers;

use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityPassword\Dtos\PasswordDto;
use Eyegil\SecurityPassword\Services\PasswordService;
use Illuminate\Http\Request;

#[Controller("/api/v1/password")]
class PasswordController
{

    public function __construct(
        private PasswordService $passwordService
    ) {}

    #[Put()]
    public function updatePassword(Request $request)
    {
        $passwordDto = PasswordDto::fromRequest($request)->validateUpdate();
        $this->passwordService->update($passwordDto);
    }

    #[Put("/force_update")]
    public function forceUpdate(Request $request)
    {
        $passwordDto = PasswordDto::fromRequest($request)->validateUpdate();
        $this->passwordService->forceUpdate($passwordDto);
    }

    #[Put("/forgot")]
    public function forgotPassword(Request $request)
    {
        if (!$request->query->has('key')) throw new BusinessException("Parameter Key not found", "PASS-00001");
        $encriptionKey = new EncriptionKey($request->query("key"));
        
        $data = $encriptionKey->validate();
        if(!$data) throw new BusinessException("key not valid", "PASS-00001");

        $passwordDto = PasswordDto::fromRequest($request)->validateForgotPassword();
        $passwordDto->user_id = $data->user_id;
        $this->passwordService->forgotUpdate($passwordDto);
    }
}
