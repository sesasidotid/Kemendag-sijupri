<?php

namespace Eyegil\SijupriSiap\Services;

use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SijupriSiap\Dtos\UserUnitKerjaDto;
use Eyegil\SijupriSiap\Models\UserUnitKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserUnitKerjaService
{
    public function __construct(
        private UserAuthenticationService $userAuthenticationService,
        private UserService $userService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $userContext = user_context();
        if ($userContext->application_code == "sijupri-instansi") {
            $pageable->addEqual("unitKerja|instansi_id", $userContext->getDetails("instansi_id"));
        } else if ($userContext->application_code == "sijupri-unit-kerja") {
            $pageable->addEqual("unit_kerja_id", $userContext->getDetails("unit_kerja_id"));
        }

        return $pageable->with(['user', 'unitKerja', 'instansi'])->searchHas(UserUnitKerja::class, ['user', 'unitKerja', 'instansi']);
    }

    public function findAll()
    {
        return UserUnitKerja::all();
    }

    public function findByNip($nip)
    {
        $userUnitKerja = UserUnitKerja::findOrThrowNotFound($nip);
        $user = $userUnitKerja->user;
        $userUnitKerja->name = $user->name;
        $userUnitKerja->phone = $user->phone;
        $userUnitKerja->email = $user->email;
        return $userUnitKerja;
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return UserUnitKerja::where("unit_kerja_id", $unit_kerja_id)
            ->where("delete_flag", false)
            ->where("inactive_flag", false)
            ->get();
    }

    public function save(UserUnitKerjaDto $userUnitKerjaDto)
    {
        return DB::transaction(function () use ($userUnitKerjaDto) {
            $userContext = user_context();

            $userUnitKerjaDto->id = $userUnitKerjaDto->nip;
            $userUnitKerjaDto->password = $userUnitKerjaDto->nip;
            $userUnitKerjaDto->role_code_list = ['USER_UNIT_KERJA'];
            $userUnitKerjaDto->application_code = 'sijupri-unit-kerja';
            $userUnitKerjaDto->channel_code_list = ['WEB', 'MOBILE'];
            $this->userAuthenticationService->register($userUnitKerjaDto);

            $userUnitKerja = new UserUnitKerja();
            $userUnitKerja->fromArray($userUnitKerjaDto->toArray());
            $userUnitKerja->created_by = $userContext->id;
            $userUnitKerja->save();

            return $userUnitKerja;
        });
    }

    public function update(UserUnitKerjaDto $userUnitKerjaDto)
    {
        return DB::transaction(function () use ($userUnitKerjaDto) {
            $userContext = user_context();

            $userUnitKerja = UserUnitKerja::findOrThrowNotFound($userUnitKerjaDto->nip);
            $userUnitKerja->updated_by = $userContext->id;
            $userUnitKerja->unit_kerja_id = $userUnitKerjaDto->unit_kerja_id;

            $userUnitKerjaDto->id = $userUnitKerjaDto->nip;
            $this->userAuthenticationService->update($userUnitKerjaDto);
            $userUnitKerja->save();

            return $userUnitKerja;
        });
    }

    public function delete($nip)
    {
        return DB::transaction(function () use ($nip) {
            $this->userService->delete($nip);
            $userUnitKerja = $this->findByNip($nip);
            $userUnitKerja->delete();
        });
    }
}
