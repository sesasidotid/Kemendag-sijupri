<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Exceptions\BusinessException;
use Eyegil\SijupriMaintenance\Dtos\SystemConfigurationDto;
use Eyegil\SijupriMaintenance\Models\SystemConfiguration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SystemConfigurationService
{
    public function findAll()
    {
        return SystemConfiguration::all();
    }

    public function findByCode($code): SystemConfiguration
    {
        return SystemConfiguration::findOrThrowNotFound($code);
    }

    public function update(SystemConfigurationDto $systemConfigurationDto)
    {
        return DB::transaction(function () use ($systemConfigurationDto) {
            $userContext = user_context();

            $sysConf = $this->findByCode($systemConfigurationDto->code);

            if (@preg_match('/' . $sysConf->rule . '/', '') === false) {
                throw new BusinessException("Invalid stored regex rule", "");
            }

            $validator = Validator::make(['value' => $systemConfigurationDto->value], [
                'value' => ['regex:/' . $sysConf->rule . '/']
            ]);

            if ($validator->fails()) {
                throw new BusinessException("Invalid input type", "");
            }

            $sysConf->value = $systemConfigurationDto->value;
            $sysConf->updated_by = $userContext->id;
            $sysConf->save();

            return $sysConf;
        });
    }

    public function updateBatch($system_configuration_dto_list)
    {
        return DB::transaction(function () use ($system_configuration_dto_list) {
            foreach ($system_configuration_dto_list as $key => $system_configuration_dto) {
                $systemConfigurationDto = (new SystemConfigurationDto())->fromArray((array) $system_configuration_dto);
                $this->update($systemConfigurationDto);
            }
        });
    }
}
