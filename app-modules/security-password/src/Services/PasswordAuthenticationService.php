<?php

namespace Eyegil\SecurityPassword\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SecurityBase\LoginContext;
use Eyegil\SecurityBase\Services\IAuthenticationService;
use Eyegil\SecurityPassword\Dtos\PasswordDto;
use Illuminate\Support\Facades\DB;

class PasswordAuthenticationService implements IAuthenticationService
{

    public function __construct(
        private PasswordService $passwordService
    ) {}

    public function register(string $user_id, string $password, $options = null): void
    {
        DB::transaction(function () use ($user_id,  $password) {
            $passwordDto = new PasswordDto();
            $passwordDto->user_id = $user_id;
            $passwordDto->password = $password;

            $this->passwordService->save($passwordDto);
        });
    }

    public function login(string $user_id, string $password, $options = null): LoginContext
    {
        $loginContext = new LoginContext();
        if (!$this->passwordService->validatePassword($user_id, $password)) {
            throw new BusinessException("invalid credential", "PSS-00001");
        }

        $loginContext->user_id = $user_id;
        $loginContext->status = true;
        $loginContext->message = "credentioal matches";
        return $loginContext;
    }
}
