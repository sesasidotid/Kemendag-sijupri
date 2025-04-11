<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Services\UserAuthenticationService;
use Eyegil\SijupriUkom\Dtos\ExaminerUkomDto;
use Eyegil\SijupriUkom\Models\ExaminerUkom;
use Illuminate\Support\Facades\DB;

class ExaminerUkomService
{
    public function __construct(
        private UserAuthenticationService $userAuthenticationService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("delete_flag", false);
        $pageable->addEqual("inactive_flag", false);
        return $pageable->with(['user'])->searchHas(ExaminerUkom::class, ['user']);
    }

    public function findById($id): ExaminerUkom
    {
        return ExaminerUkom::findOrThrowNotFound($id);
    }

    public function findByNip($nip)
    {
        return ExaminerUkom::where('nip', $nip)->first();
    }

    public function save(ExaminerUkomDto $examinerUkomDto)
    {
        DB::transaction(function () use ($examinerUkomDto) {
            $userContext = user_context();

            if ($this->findByNip($examinerUkomDto->nip)) {
                throw new RecordExistException("canot use existing nip");
            }

            $examinerUkomDto->id = "EU-" . $examinerUkomDto->nip;
            $examinerUkomDto->role_code_list = [];
            $examinerUkomDto->application_code = 'siukom-examiner';
            $examinerUkomDto->channel_code_list = ['WEB', 'MOBILE'];
            $this->userAuthenticationService->register($examinerUkomDto);
            $examinerUkomDto->id = null;

            $examinerUkom = new ExaminerUkom();
            $examinerUkom->fromArray($examinerUkomDto->toArray());
            $examinerUkom->created_by = $userContext->id;
            $examinerUkom->user_id = "EU-" . $examinerUkomDto->nip;
            $examinerUkom->saveWithUuid();

            return $examinerUkom;
        });
    }

    public function update(ExaminerUkomDto $examinerUkomDto)
    {
        DB::transaction(function () use ($examinerUkomDto) {
            $userContext = user_context();

            $examinerUkom = $this->findById($examinerUkomDto->id);
            $examinerUkom->updated_by = $userContext->id;
            $examinerUkom->jenis_kelamin_code = $examinerUkomDto->jenis_kelamin_code;

            $examinerUkomDto->id =  "EU-" . $examinerUkom->nip;
            $this->userAuthenticationService->update($examinerUkomDto);
            $examinerUkom->save();

            return $examinerUkom;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $userContext = user_context();

            $examinerUkom = $this->findById($id);
            $examinerUkom->updated_by = $userContext->id;
            $examinerUkom->delete_flag = true;
            $examinerUkom->save();

            return $examinerUkom;
        });
    }
}
