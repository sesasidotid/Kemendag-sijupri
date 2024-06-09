<?php

namespace App\Http\Controllers\Security\Service;

use App\Http\Controllers\SearchService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class UserService extends User
{
    use SearchService;

    public function findAll()
    {
        return $this->where('delete_flag', false)->get();
    }

    public function findByIdIncludeDeleted($nip): ?UserService
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->first();
    }

    public function findById($nip): ?UserService
    {
        return $this
            ->where('nip', $nip)
            ->first();
    }

    public function findByNip($nip)
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByRoleCode($role_code)
    {
        return $this
            ->where('role_code', $role_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByRoleBase($role_code)
    {
        return $this->whereHas('role', function ($query) use ($role_code) {
            $query->where('base', $role_code);
        })->where('delete_flag', false)->get();
    }

    public function findByRoleBaseAndInstansiId($role_code, $instansi_id)
    {
        return $this->whereHas('role', function ($query) use ($role_code) {
            $query->where('base', $role_code);
        })->where('instansi_id', $instansi_id)->where('delete_flag', false)->get();
    }

    public function findByRoleCodeList(array $role_code_list)
    {
        return $this
            ->whereIn('role_code', $role_code_list)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByTipeInstansiCodeAndRoleBase($tipe_instansi_code, $role_code)
    {
        return $this->whereHas('role', function ($query) use ($role_code) {
            $query->where('base', $role_code);
        })
            ->where('tipe_instansi_code', $tipe_instansi_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByTipeInstansiCodeAndRoleCode($tipe_instansi_code, $role_code)
    {
        return $this
            ->where('tipe_instansi_code', $tipe_instansi_code)
            ->where('role_code', $role_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function findByUnitKerjaId($unit_kerja_id)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->get();
    }

    public function findByUnitKerjaIdAndRoleCode($unit_kerja_id, $role_code)
    {
        return $this
            ->where('unit_kerja_id', $unit_kerja_id)
            ->where('role_code', $role_code)
            ->get();
    }

    public function findByUnitKerjaIdAndRoleBase($unit_kerja_id, $role_code)
    {
        return $this->whereHas('role', function ($query) use ($role_code) {
            $query->where('base', $role_code);
        })->where('unit_kerja_id', $unit_kerja_id)->get();
    }

    public function findByRoleCodeAndParentId($role_code, $unit_kerja_id)
    {
        return $this
            ->where('parent_id', $unit_kerja_id)
            ->where('role_code', $role_code)
            ->where('delete_flag', false)
            ->get();
    }

    public function customSave()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip;
            $this->save();
            return $this;
        });
    }

    public function customUpdate()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->save();
            return $this;
        });
    }

    public function customDelete()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
            return $this;
        });
    }

    public function urlAtasan()
    {
        return URL::temporarySignedRoute('/akp/review/atasan', now()->addDays(30), ['nip' => $this->nip]);
    }

    public function urlRekan()
    {
        return URL::temporarySignedRoute('/akp/review/rekan', now()->addDays(30), ['nip' => $this->nip]);
    }
}
