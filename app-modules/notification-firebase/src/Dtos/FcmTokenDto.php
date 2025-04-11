<?php

namespace Eyegil\NotificationFirebase\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class FcmTokenDto extends BaseDto
{
    public $token;
    public $device_id;

    public function validateUpdate()
    {
        return $this->validate([
            'token' => 'required|string',
            'device_id' => 'required|string',
        ]);
    }
}
