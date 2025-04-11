<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\Models\UserApplicationChannel;
use Illuminate\Support\Facades\DB;

class UserApplicationChannelService
{
    public function __construct() {}
    public function findAll()
    {
        return UserApplicationChannel::all();
    }

    public function findById($id): UserApplicationChannel
    {
        return UserApplicationChannel::findOrThrowNotFound($id);
    }

    public function findByUserId($user_id)
    {
        return UserApplicationChannel::where("user_id", $user_id)->get();
    }

    public function findByUserIdAndApplicationCode($user_id, $application_code)
    {
        return UserApplicationChannel::where("user_id", $user_id)->where("application_code", $application_code)->get();
    }

    public function findByUserIdAndChannelCode($user_id, $channel_code)
    {
        return UserApplicationChannel::where("user_id", $user_id)->where("channel_code", $channel_code)->get();
    }

    public function findByUserIdAndApplicationCodeAndChannelCode($user_id, $application_code, $channel_code)
    {
        return UserApplicationChannel::where("user_id", $user_id)->where("application_code", $application_code)->where("channel_code", $channel_code)->first();
    }

    public function save(UserDto $userDto): void
    {
        DB::transaction(function () use ($userDto) {
            $userContext = user_context();

            foreach ($userDto->channel_code_list as $key => $channel_code) {
                $userApplicationChannel = new UserApplicationChannel();
                $userApplicationChannel->user_id = $userDto->id;
                $userApplicationChannel->channel_code = $channel_code;
                $userApplicationChannel->application_code = $userDto->application_code;
                $userApplicationChannel->created_by = $userContext->id;

                $userApplicationChannel->saveWithUuid();
            }
        });
    }

    public function update(UserDto $userDto): void
    {
        DB::transaction(function () use ($userDto) {
            UserApplicationChannel::where("user_id", $userDto->id)->delete();
            $this->save($userDto);
        });
    }
}
