<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\UkomRegistrationRulesDto;
use Eyegil\SijupriUkom\Services\UkomRegistrationRulesService;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_registration_rules")]
class UkomRegistrationRulesController
{
    public function __construct(
        private UkomRegistrationRulesService $ukomRegistrationRulesService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->ukomRegistrationRulesService->findSearch(new Pageable($request->query()), $request->query());
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->ukomRegistrationRulesService->findById($id);
    }

    #[Get("/jenjang/{jenjang_code}")]
    public function findByJenjangCode($jenjang_code)
    {
        return $this->ukomRegistrationRulesService->findByJenjangCode($jenjang_code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $ukomRegistrationRulesDto = UkomRegistrationRulesDto::fromRequest($request)->validateSave();
        $ukomRegistrationRulesDto->validateSave();
        return $this->ukomRegistrationRulesService->save($ukomRegistrationRulesDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $ukomRegistrationRulesDto = UkomRegistrationRulesDto::fromRequest($request)->validateUpdate();
        return $this->ukomRegistrationRulesService->update($ukomRegistrationRulesDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        $this->ukomRegistrationRulesService->delete($id);
    }
}
