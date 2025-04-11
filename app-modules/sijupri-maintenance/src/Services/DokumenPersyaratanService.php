<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\DokumenPersyaratanDto;
use Eyegil\SijupriMaintenance\Models\DokumenPersyaratan;
use Illuminate\Support\Facades\DB;

class DokumenPersyaratanService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(DokumenPersyaratan::class);
    }

    public function findAll()
    {
        return DokumenPersyaratan::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return DokumenPersyaratan::findOrThrowNotFound($id);
    }

    public function findByAssociation($association)
    {
        return DokumenPersyaratan::where('association', $association)->where('delete_flag', false)->get();
    }

    public function findByAssociationAndAdditionals($association, array $additionals)
    {
        $query = DokumenPersyaratan::where('association', $association)->where('delete_flag', false);
        foreach ($additionals as $key => $additional) {
            if ($additional)
                $query->where($key, $additional);
        }
        return $query->get();
    }

    public function save(DokumenPersyaratanDto $dokumenPersyaratanDto)
    {
        return DB::transaction(function () use ($dokumenPersyaratanDto) {
            $userContext = user_context();
            $dokumenPersyaratan = new DokumenPersyaratan();
            $dokumenPersyaratan->fromArray($dokumenPersyaratanDto->toArray());
            $dokumenPersyaratan->created_by = $userContext->id;
            $dokumenPersyaratan->saveWithUUid();

            return $dokumenPersyaratan;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $userContext = user_context();
            $dokumenPersyaratan = $this->findById($id);

            $dokumenPersyaratan['updated_by'] = $userContext->id;
            $dokumenPersyaratan['delete_flag'] = true;
            $dokumenPersyaratan->save();

            return $dokumenPersyaratan;
        });
    }
}
