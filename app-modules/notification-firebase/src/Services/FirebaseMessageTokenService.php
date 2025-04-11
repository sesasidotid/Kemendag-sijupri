<?php

namespace Eyegil\NotificationFirebase\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\NotificationFirebase\Models\FirebaseMessageToken;
use Eyegil\NotificationFirebase\Dtos\FcmTokenDto;
use Eyegil\SecurityBase\Services\DeviceService;
use Illuminate\Support\Facades\DB;

class FirebaseMessageTokenService
{

    public function __construct(
        private DeviceService $deviceService
    ) {}

    public function findById($id)
    {
        return FirebaseMessageToken::findOrThrowNotFound($id);
    }

    public function findByDeviceId($device_id)
    {
        return FirebaseMessageToken::where('device_id', $device_id)->first();
    }

    public function findByDeviceUserId($user_id)
    {
        return FirebaseMessageToken::whereHas("device", function ($query) use ($user_id) {
            $query->where("user_id", $user_id);
        })->get();
    }

    public function findByToken($token)
    {
        return FirebaseMessageToken::where('token', $token)->first();
    }

    public function getTokenListByDeviceUserId($user_id): array
    {
        return $this->findByDeviceUserId($user_id)->map(function ($fcmToken) {
            return $fcmToken->token;
        })->toArray();
    }

    public function save(FcmTokenDto $fcmTokenDto)
    {
        return DB::transaction(function () use ($fcmTokenDto) {
            $firebaseMessageToken = $this->findByDeviceId($fcmTokenDto->device_id);
            if ($firebaseMessageToken) {
                throw new RecordExistException("device id already exist");
            }

            $firebaseMessageToken = new FirebaseMessageToken();
            $firebaseMessageToken->token = $fcmTokenDto->token;
            $firebaseMessageToken->device_id = $fcmTokenDto->device_id;
            $firebaseMessageToken->saveWithUUid();

            return $firebaseMessageToken;
        });
    }

    public function update(FcmTokenDto $fcmTokenDto)
    {
        return DB::transaction(function () use ($fcmTokenDto) {
            $firebaseMessageToken = $this->findByDeviceId($fcmTokenDto->device_id);
            $firebaseMessageToken->token = $fcmTokenDto->token;
            $firebaseMessageToken->save();

            return $firebaseMessageToken;
        });
    }

    public function deleteByToken($token)
    {
        return DB::transaction(function () use ($token) {
            $firebaseMessageToken = $this->findByToken($token);
            $firebaseMessageToken->delete();

            return $firebaseMessageToken;
        });
    }

    public function deleteByTokenList(array $tokenList)
    {
        DB::transaction(function () use ($tokenList) {
            FirebaseMessageToken::whereIn('token', $tokenList)->delete();
        });
    }
}
