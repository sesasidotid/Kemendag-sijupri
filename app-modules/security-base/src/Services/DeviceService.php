<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\DeviceDto;
use Eyegil\SecurityBase\Models\Device;
use Illuminate\Support\Facades\DB;

class DeviceService
{
    public function __construct() {}

    public function findById($id): ?Device
    {
        return Device::find($id);
    }

    public function findByUserId($user_id)
    {
        return Device::where('user_id', $user_id)->get();
    }

    public function save(DeviceDto $deviceDto): Device
    {
        return DB::transaction(function () use ($deviceDto) {
            $device = new Device();
            $device->fromArray($deviceDto->toArray());
            $device->save();

            return $device;
        });
    }

    public function update(DeviceDto $deviceDto): Device
    {
        return DB::transaction(function () use ($deviceDto) {
            $device = $this->findById($deviceDto->id);
            $device->user_id = $deviceDto->user_id;
            $device->save();

            return $device;
        });
    }
}
