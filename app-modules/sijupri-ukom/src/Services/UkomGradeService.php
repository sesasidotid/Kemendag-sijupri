<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UkomGradeService
{

    public function __construct(
        private UkomBanService $ukomBanService
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setJoinQueries(function (Pageable $instance, Builder $query) {
            $query
                ->leftJoin("ukm_participant", "ukm_participant.id", $instance->getTable() . ".participant_id")
                ->leftJoin("ukm_participant_room", "ukm_participant_room.participant_id", "ukm_participant.id")
                ->leftJoin("ukm_room", "ukm_room.id", "ukm_participant_room.room_id")
                // ->leftJoin("mnt_jabatan as tja", "tja.code", "ukm_participant.jabatan_code")
                ->leftJoin("mnt_jabatan as tjan", "tjan.code", "ukm_participant.next_jabatan_code")
                // ->leftJoin("mnt_jenjang as tjj", "tjj.code", "ukm_participant.jenjang_code")
                ->leftJoin("mnt_jenjang as tjjn", "tjjn.code", "ukm_participant.next_jenjang_code");
        })->setOrderQueries(function (Pageable $instance, Builder $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.last_updated', 'desc');
            }
        })->setWhereQueries(function (Pageable $instance, Builder $query) {
            $query->where($instance->getTable() . '.delete_flag', false);
            $query->where($instance->getTable() . '.inactive_flag', false);

            $participant_name = $instance->where['participant_ukom']['child']['name']['condition']['general']['value'] ?? null;
            if ($participant_name)
                $query->where('ukm_participant.name', 'ILIKE', '%' . $participant_name . '%');

            $participant_nip = $instance->where['participant_ukom']['child']['nip']['condition']['general']['value'] ?? null;
            if ($participant_nip)
                $query->where('ukm_participant.nip', 'ILIKE', '%' . $participant_nip . '%');

            $room_name = $instance->where['room_ukom']['child']['name']['condition']['general']['value'] ?? null;
            if ($room_name)
                $query->where('ukm_room.name', 'ILIKE', '%' . $room_name . '%');
        }, true)->search(UkomGrade::class);
    }

    public function findById($id)
    {
        return UkomGrade::findOrThrowNotFound($id);
    }

    public function findByParticipantId($participantId)
    {
        $userContext = user_context();
        $isAdmin = ((optional($userContext)->application_code ?? "") == "sijupri-admin");

        $query = UkomGrade::with(["catGrade", "wawancaraGrade", "seminarGrade", "makalahGrade", "praktikGrade", "portofolioGrade", "studiKasusGrade"])
            ->where('participant_id', $participantId);

        if (!$isAdmin) {
            $query->whereHas("participantUkom", function ($q) {
                $q->where("grade_visibility", true);
            });
        }

        return $query->first();
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $userContext = user_context();

            $ukomGrade = $this->findById($id);
            $ukomGrade->updated_by = $userContext->id;
            $ukomGrade->delete_flag = true;
            $ukomGrade->save();
        });
    }

    public function publishAll()
    {
        DB::transaction(function () {
            ParticipantUkom::where("grade_visibility", false)->update([
                "grade_visibility" => true
            ]);
        });

        UkomGrade::where("passed", false)->get()->each(function (UkomGrade $ukomGrade) {
            $this->ukomBanService->banByParticipantId($ukomGrade->participant_id);
        });
    }
}
