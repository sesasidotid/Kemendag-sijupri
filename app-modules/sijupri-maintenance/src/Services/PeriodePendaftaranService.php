<?php

namespace Eyegil\SijupriMaintenance\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Models\PeriodePendaftaran;
use Illuminate\Support\Facades\DB;

class PeriodePendaftaranService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(PeriodePendaftaran::class);
    }

    public function findAll()
    {
        $this->setExpiredRecordToInactive();
        return PeriodePendaftaran::where('delete_flag', false)
            ->orderBy('last_updated', 'ASC')
            ->get();
    }

    public function findById($id)
    {
        $this->setExpiredRecordToInactive();
        return PeriodePendaftaran::findOrThrowNotFound($id);
    }

    public function findAllByTypeAndInactiveFlag($type, $inactive_flag)
    {
        $this->setExpiredRecordToInactive();
        return PeriodePendaftaran::where('type', $type)->where('inactive_flag', $inactive_flag)->get();
    }

    public function getActiveByType($type)
    {
        $this->setExpiredRecordToInactive();
        return PeriodePendaftaran::where('type', $type)->where('inactive_flag', false)->firstOrThrowNotFound();
    }

    public function switchActivation($id)
    {
        $this->setExpiredRecordToInactive();
        DB::transaction(function () use ($id) {
            $userContext = user_context();
            $periodePendaftaran = $this->findById($id);

            $periodePendaftaran['updated_by'] = $userContext->id;
            $periodePendaftaran['inactive_flag'] = !$periodePendaftaran['inactive_flag'];
            $periodePendaftaran->save();
        });
    }

    public function save(array $periodePendaftaranDto): PeriodePendaftaran
    {
        $this->setExpiredRecordToInactive();
        return DB::transaction(function () use ($periodePendaftaranDto) {
            $userContext = user_context();
            $periodePendaftaran = new PeriodePendaftaran();
            $periodePendaftaran->fromArray($periodePendaftaranDto);
            $periodePendaftaran->created_by = $userContext->id;
            $periodePendaftaran->saveWithUUid();
            return $periodePendaftaran;
        });
    }

    public function update(array $periodePendaftaranDto): PeriodePendaftaran
    {
        $this->setExpiredRecordToInactive();
        return DB::transaction(function () use ($periodePendaftaranDto) {
            $userContext = user_context();
            $periodePendaftaran = $this->findById($periodePendaftaranDto['id']);

            $periodePendaftaran->fromArray($periodePendaftaranDto);
            $periodePendaftaran->updated_by = $userContext->id;
            $periodePendaftaran->save();

            return $periodePendaftaran;
        });
    }

    public function delete($id)
    {
        $this->setExpiredRecordToInactive();
        DB::transaction(function () use ($id) {
            $userContext = user_context();
            $periodePendaftaran = $this->findById($id);

            $periodePendaftaran->updated_by = $userContext->id;
            $periodePendaftaran->delete_flag = true;
            $periodePendaftaran->inactive_flag = true;
            $periodePendaftaran->save();
        });
    }

    private function setExpiredRecordToInactive()
    {
        PeriodePendaftaran::where('end_date', '<', Carbon::today())
            ->where('inactive_flag', false)
            ->update(['inactive_flag' => true]);
    }
}
