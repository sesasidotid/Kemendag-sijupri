<?php

namespace Eyegil\SecurityBase\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class DeviceDto extends BaseDto {
    public $id;
    public $device_model;
    public $os_version;
    public $app_version;
    public $channel_code;
    public $user_id;
}