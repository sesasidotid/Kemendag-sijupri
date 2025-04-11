<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UkomGradeService
{

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setJoinQueries(function (Pageable $instance, Builder $query) {
            $query
                ->join("ukm_room", "ukm_room.id", $instance->getTable() . ".room_ukom_id")
                ->join("ukm_participant", "ukm_participant.id", $instance->getTable() . ".participant_id")
                ->join("mnt_jabatan as tja", "tja.code", "ukm_participant.jabatan_code")
                ->join("mnt_jabatan as tjan", "tjan.code", "ukm_participant.next_jabatan_code")
                ->join("mnt_jenjang as tjj", "tjj.code", "ukm_participant.jenjang_code")
                ->join("mnt_jenjang as tjjn", "tjjn.code", "ukm_participant.next_jenjang_code");
        })->setOrderQueries(function (Pageable $instance, Builder $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->setWhereQueries(function (Pageable $instance, Builder $query) {
            $participant_name = $instance->where['participant_ukom']['child']['name']['condition']['general']['value'] ?? null;
            Log::info("participant_name " . $participant_name);
            if ($participant_name)
                $query->where('ukm_participant.name', 'like', $participant_name);
            $participant_nip = $instance->where['participant_ukom']['child']['nip']['condition']['general']['value'] ?? null;
            Log::info("participant_nip " . $participant_nip);
            if ($participant_nip)
                $query->where('ukm_participant.nip', 'like', $participant_nip);
            $room_name = $instance->where['room_ukom']['child']['name']['condition']['general']['value'] ?? null;
            Log::info("room_name " . $room_name);
            if ($room_name)
                $query->where('ukm_room.name', 'like', $room_name);
        }, true)->search(UkomGrade::class);
    }

    public function findById($id)
    {
        return UkomGrade::findOrThrowNotFound($id);
    }
}
