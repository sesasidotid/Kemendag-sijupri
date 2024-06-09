<?php

namespace App\Http\Controllers\Security\Service;

use App\Http\Controllers\SearchService;
use App\Models\Security\Role;
use App\Models\Security\RoleMenu;
use Illuminate\Support\Facades\DB;

class RoleService extends Role
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findById($code): ?RoleService
    {
        return $this->where('code', $code)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByRoleBase($role_base)
    {
        return $this->where('base', $role_base)
            ->where('delete_flag', false)
            ->get();
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
        });
    }

    public function customUpdate()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
        });
    }

    public function updateRoleMenu(array $menuCodeList)
    {
        DB::transaction(function () use ($menuCodeList) {
            $userContext = auth()->user();
            $data = [];
            foreach ($menuCodeList as $menuCode) {
                $data[] = [
                    'role_code' => $this->code,
                    'menu_code' => $menuCode,
                    'created_by' => $userContext->nip
                ];
            }

            RoleMenu::where('role_code', $this->code)->delete();
            RoleMenu::insert($data);
        });
    }

    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
        });
    }
}
