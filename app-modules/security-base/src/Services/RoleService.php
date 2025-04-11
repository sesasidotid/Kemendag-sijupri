<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\Base\Pageable;
use Eyegil\SecurityBase\Dtos\RoleDto;
use Eyegil\SecurityBase\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function __construct(
        private RoleMenuService $roleMenuService,
    ) {}

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(Role::class, ['application']);
    }

    public function findAll()
    {
        return Role::all();
    }

    public function findByCode(string $code): Role
    {
        return Role::findOrThrowNotFound($code);
    }

    public function findByApplicationCode($application_code)
    {
        return Role::whereHas("application", function ($query) use ($application_code) {
            $query->where('code', $application_code);
        })->get();
    }

    public function save(RoleDto $roleDto): Role
    {
        return DB::transaction(function () use ($roleDto) {
            $userContext = user_context();

            $role = new Role();
            $role->fill($roleDto->toArray());
            $role->created_by = $userContext->id;
            $role->save();

            $this->roleMenuService->save($roleDto);

            return $role;
        });
    }

    public function update(RoleDto $roleDto): Role
    {
        return DB::transaction(function () use ($roleDto) {
            $userContext = user_context();

            $role = $this->findByCode($roleDto->code);
            $role->updated_by = $userContext->id;
            $role->save();

            $this->roleMenuService->update($roleDto);

            return $role;
        });
    }

    public function delete(string $id): Role
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();

            $role = $this->findByCode($id);
            $role->updated_by = $userContext->id;
            $role->delete_flag = false;

            $role->save();
        });
    }
}
