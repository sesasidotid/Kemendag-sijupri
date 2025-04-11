<?php

namespace Eyegil\SijupriSiap\Services;

use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SijupriSiap\Dtos\UserInstansiDto;
use Eyegil\SijupriSiap\Models\UserInstansi;
use Illuminate\Support\Facades\DB;

class UserInstansiService
{
    public function __construct(
        private UserAuthenticationService $userAuthenticationService,
        private UserService $userService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if ($userContext->application_code == "sijupri-instansi") {
            $pageable->addEqual("unitkerja|instansi_id", $userContext->getDetails("instansi_id"));
        }
        return $pageable->with(['user'])->searchHas(UserInstansi::class, ['user']);
    }

    public function findAll()
    {
        return UserInstansi::all();
    }

    public function findByNip($nip)
    {
        $userInstansi = UserInstansi::findOrThrowNotFound($nip);
        $user = $userInstansi->user;
        $userInstansi->name = $user->name;
        $userInstansi->phone = $user->phone;
        $userInstansi->email = $user->email;
        return $userInstansi;
    }

    public function save(UserInstansiDto $userInstansiDto)
    {
        return DB::transaction(function () use ($userInstansiDto) {
            $userContext = user_context();

            $userInstansiDto->id = $userInstansiDto->nip;
            $userInstansiDto->password = $userInstansiDto->nip;
            $userInstansiDto->role_code_list = ['USER_INSTANSI'];
            $userInstansiDto->application_code = 'sijupri-instansi';
            $userInstansiDto->channel_code_list = ['WEB', 'MOBILE'];
            $this->userAuthenticationService->register($userInstansiDto);

            $userInstansi = new UserInstansi();
            $userInstansi->fromArray($userInstansiDto->toArray());
            $userInstansi->created_by = $userContext->id;
            $userInstansi->save();

            return $userInstansi;
        });
    }

    public function update(UserInstansiDto $userInstansiDto)
    {
        return DB::transaction(function () use ($userInstansiDto) {
            $userContext = user_context();

            $userInstansi = UserInstansi::findOrThrowNotFound($userInstansiDto->nip);
            $userInstansi->updated_by = $userContext->id;
            $userInstansi->instansi_id = $userInstansiDto->instansi_id;

            $userInstansiDto->id = $userInstansiDto->nip;
            $this->userAuthenticationService->update($userInstansiDto);
            $userInstansi->save();

            return $userInstansi;
        });
    }

    public function delete($nip)
    {
        return DB::transaction(function () use ($nip) {
            $this->userService->delete($nip);
            $userInstansi = $this->findByNip($nip);
            $userInstansi->delete();
        });
    }
}
