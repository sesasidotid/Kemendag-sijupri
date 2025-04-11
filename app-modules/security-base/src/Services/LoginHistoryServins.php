<?php

namespace Eyegil\SecurityBase\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Models\Application;
use Eyegil\SecurityBase\Models\LoginHistory;
use Illuminate\Support\Facades\DB;

class LoginHistoryServins
{
    public function __construct() {}

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(LoginHistory::class, ['device']);
    }

    public function findById($id)
    {
        return LoginHistory::findOrThrowNotFound($id);
    }

    public function login($user_id, $device_id = null)
    {
        DB::transaction(function () use ($user_id, $device_id) {
            $loginHistory = new LoginHistory();
            $loginHistory->login_at = Carbon::now();
            $loginHistory->user_id = $user_id;
            $loginHistory->device_id = $device_id;
            $loginHistory->saveWithUUid();
        });
    }

    public function logout($id)
    {
        DB::transaction(function () use ($id) {
            $loginHistory = $this->findById($id);
            $loginHistory->logout_at = Carbon::now();
            $loginHistory->save();
        });
    }
}
