<?php

namespace Eyegil\SecurityBase\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Dtos\AuthenticationDto;
use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Illuminate\Http\Request;

#[Controller("/api/v1/user")]
class UserController
{
    public function __construct(
        private UserService $userService,
        private UserAuthenticationService $userAuthenticationService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->userService->findAll();
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->userService->findSearch(new Pageable($request->query()));
    }

    #[Get("/{id}")]
    public function findById(Request $request)
    {
        return $this->userService->findById($request->id);
    }

    #[Get("/application_channel/{application_code}/{channel_code}")]
    public function findByApplicationCodeAndChannel(Request $request)
    {
        return $this->userService->findByApplicationCodeAndChannel($request->application_code, $request->channel_code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $userDto = UserDto::fromRequest($request)->validateSave();
        return $this->userAuthenticationService->register($userDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $userDto = UserDto::fromRequest($request)->validateSave();
        return $this->userAuthenticationService->update($userDto);
    }

    #[Delete("/{id}")]
    public function delete(Request $request)
    {
        return $this->userAuthenticationService->delete($request->id);
    }
}
