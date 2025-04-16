<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SecurityBase\Enums\UserStatus;
use Eyegil\SecurityBase\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function __construct(
        private UserRoleService $userRoleService,
        private UserApplicationChannelService $userApplicationChannelService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addNotEqualIn("status", [UserStatus::DELETED->value]);
        $pageable->addEqual("delete_flag", false);
        $pageable->addEqual("inactive_flag", false);
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(User::class, ['userApplicationChannel']);
    }

    public function findAll()
    {
        return User::all();
    }

    public function findByIdv2($id)
    {
        return User::find($id);
    }

    public function findById($id): User
    {
        return User::findOrThrowNotFound($id);
    }

    public function findByApplicationCodeAndChannel($application_code, $channel_code)
    {
        return User::whereHas("userApplicationChannel", function ($query) use ($application_code, $channel_code) {
            $query->where('application_code', $application_code);
            $query->where('channel_code', $channel_code);
        })->get();
    }

    public function save(UserDto $userDto): User
    {
        $userContext = user_context();

        return DB::transaction(function () use ($userDto, $userContext) {
            $userExist = User::where("id", $userDto->id)->where("status", UserStatus::DELETED->value)->where("delete_flag", true)->first();
            if ($userExist) {
                if($userExist->status != UserStatus::DELETED->value || !$userExist->delete_flag) {
                    throw new RecordExistException("user already exist");
                }

                if (config('eyegil.security.reuseDeletedUser', false)) {
                    $userExist->fromArray($userDto->toArray());
                    $userExist->updated_by = $userContext->id;
                    $userExist->save();
                    if ($userDto->role_code_list && count($userDto->role_code_list) > 0) {
                        $this->userRoleService->update($userDto);
                    }
                    if ($userDto->channel_code_list && $userDto->application_code && count($userDto->role_code_list) > 0) {
                        $this->userApplicationChannelService->update($userDto);
                    }

                    return $userExist;
                } else {
                    throw new RecordExistException("unable to use this user id");
                }
            }


            $user = new User();
            $user->fromArray($userDto->toArray());
            $user->created_by = $userContext->id;
            $user->status =  "ACTIVE";
            $user->delete_flag = true;
            $user->inactive_flag = true;
            $user->save();
            $this->userRoleService->save($userDto);
            $this->userApplicationChannelService->update($userDto);

            return $user;
        });
    }

    public function update(UserDto $userDto): User
    {
        $userContext = user_context();
        $user = $this->findById($userDto->id);

        return DB::transaction(function () use ($userDto, $user, $userContext) {
            $user->fromArray($userDto->toArray());
            $user->updated_by = $userContext->id;
            $user->save();
            if ($userDto->role_code_list && count($userDto->role_code_list) > 0) {
                $this->userRoleService->update($userDto);
            }
            if ($userDto->channel_code_list && $userDto->application_code && count($userDto->role_code_list) > 0) {
                $this->userApplicationChannelService->update($userDto);
            }

            return $user;
        });
    }

    public function updateStatus(UserDto $userDto): User
    {
        $userContext = user_context();
        $user = $this->findById($userDto->id);

        return DB::transaction(function () use ($userDto, $user, $userContext) {
            $user->updated_by = $userContext->id;
            $user->status = $userDto->status;
            $user->save();
        });
    }

    public function delete(string $id): User
    {
        $userContext = user_context();
        $user = $this->findById($id);

        return DB::transaction(function () use ($user, $userContext) {
            $user->updated_by = $userContext->id;
            $user->delete_flag = true;
            $user->status = UserStatus::DELETED->value;
            $user->save();

            return $user;
        });
    }
}
