<?php

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use App\Exceptions\BusinessException;
use App\Models\Audit\AuditAktivitas;
use Closure;
use Illuminate\Support\Facades\DB;

class AccessMethodMiddleware
{
    public function handle($request, Closure $next)
    {
        $userContext = auth()->user();
        $access_method = $userContext->access_method;

        $method = $request->method();
        $action = $this->getActionName($method);

        if ($access_method[$action]) {
            $actionName =  $request->object;
            $request->merge(['object' => null]);

            if ($action !== "read" && $userContext->user_status != UserStatus::ACTIVE) {
                throw new BusinessException([
                    "message" => "Akun Ini Tidak Aktif",
                    "error code" => "SEC-000003",
                    "code" => 500
                ], 500);
            }

            $response = $next($request);

            if ($action !== "read") {
                DB::transaction(function () use ($request, $userContext, $action, $actionName) {
                    AuditAktivitas::create([
                        'nip' => $userContext->nip,
                        'name' => $actionName,
                        'method' => $action,
                        'ip_address' => $request->ip_address ?? '',
                        'user_agent' => $request->user_agent ?? '',
                        'tgl_access' => now(),
                    ]);
                });

                if (!session()->has('response')) {
                    switch ($action) {
                        case 'create':
                            session()->flash('response', [
                                'title' => 'Success',
                                'message' => "Berhasil",
                                'icon' => 'success',
                            ]);
                            break;
                        case 'update':
                            session()->flash('response', [
                                'title' => 'Success',
                                'message' => "Berhasil",
                                'icon' => 'success',
                            ]);
                            break;
                        case 'delete':
                            session()->flash('response', [
                                'title' => 'Success',
                                'message' => "Berhasil",
                                'icon' => 'success',
                            ]);
                            break;
                    }
                }
            }

            return $response;
        } else {
            throw $this->createAccessException($action);
        }
    }

    private function getActionName($method)
    {
        $methodActions = [
            'GET' => 'read',
            'POST' => 'create',
            'PUT' => 'update',
            'DELETE' => 'delete'
        ];

        return $methodActions[$method] ?? null;
    }

    private function createAccessException($action)
    {
        $errorMessage = "Doesn't have access for this '{$action}' action";

        return new BusinessException([
            "message" => $errorMessage,
            "error code" => "AUTH-000002",
            "code" => 500
        ], 500);
    }
}
