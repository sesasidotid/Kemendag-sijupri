<?php

namespace Eyegil\SijupriMaintenance\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\SijupriMaintenance\Dtos\SystemConfigurationDto;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Illuminate\Http\Request;

#[Controller("/api/v1/sys_conf")]
class SystemConfigurationController
{
    public function __construct(
        private SystemConfigurationService $systemConfigurationService
    ) {}

    #[Get()]
    public function findAll()
    {
        return $this->systemConfigurationService->findAll();
    }

    #[Get("/{code}")]
    public function findByCode($code)
    {
        return $this->systemConfigurationService->findByCode($code);
    }

    #[Put()]
    public function update(Request $request)
    {
        $systemConfigurationDto = SystemConfigurationDto::fromRequest($request)->validateSave();
        return $this->systemConfigurationService->update($systemConfigurationDto);
    }

    #[Put("/batch")]
    public function updateBatch(Request $request)
    {
        $request->validate(["system_configuration_dto_list" => "required"]);
        return $this->systemConfigurationService->updateBatch($request->system_configuration_dto_list);
    }
}
