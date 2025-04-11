<?php

namespace Eyegil\SijupriSiap\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SecurityBase\Services\UserService;
use Eyegil\SijupriSiap\Dtos\JFDto;
use Eyegil\SijupriSiap\Models\JF;
use Illuminate\Support\Facades\DB;

class JFService
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

        $pageable->addEqual("delete_flag", false);
        $pageable->addEqual("inactive_flag", false);
        return $pageable->with(['user'])->searchHas(JF::class, ['user', 'unitKerja']);
    }

    public function findAll()
    {
        return JF::all();
    }

    public function findByNip($nip): JF
    {
        return JF::findOrThrowNotFound($nip);
    }

    public function findByNipV2($nip)
    {
        return JF::find($nip);
    }

    public function save(JFDto $jfDto)
    {
        return DB::transaction(function () use ($jfDto) {
            $userContext = user_context();

            $jfDto->id = $jfDto->nip;
            $jfDto->password = $jfDto->nip;
            $jfDto->role_code_list = ['USER_EXTERNAL'];
            $jfDto->application_code = 'sijupri-external';
            $jfDto->channel_code_list = ['WEB', 'MOBILE'];
            $this->userAuthenticationService->register($jfDto);

            $jf = new JF();
            $jf->fromArray($jfDto->toArray());
            $jf->created_by = $userContext->id;
            $jf->save();

            return $jf;
        });
    }

    public function update(JFDto $jfDto)
    {
        return DB::transaction(function () use ($jfDto) {
            $userContext = user_context();
            if ($userContext->application_code == "sijupri-external" || $userContext->application_code == "sijupri-internal") {
                if ($userContext->id != $jfDto->nip) throw new BusinessException("Violation Access", "XXXX-1");
            }

            $jfDto->id = $jfDto->nip;
            $this->userAuthenticationService->update($jfDto);

            $jf = $this->findByNip($jfDto->nip);
            $jf->updated_by = $userContext->id;
            $jf->unit_kerja_id = $jfDto->unit_kerja_id;
            $jf->fromArray($jfDto->toArray());
            $jf->save();

            return $jf;
        });
    }

    public function delete($nip)
    {
        return DB::transaction(function () use ($nip) {
            $userContext = user_context();

            $jf = $this->findByNip($nip);
            $jf->delete_flag = true;
            $jf->updated_by = $userContext->id;
            $jf->save();

            $this->userService->delete($nip);
        });
    }
}
