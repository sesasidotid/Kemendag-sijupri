<?php

namespace Eyegil\SijupriUkom\Services;

use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\ParticipantRoomUkom;
use Illuminate\Support\Facades\DB;

class ParticipantUkomService
{
    public function __construct(
        private DocumentUkomService $documentUkomService
    ) {}

    public function findSearch(Pageable $pageable)
    {
        $pageable->addEqual("inactive_flag", false);
        $pageable->addEqual("delete_flag", false);
        return $pageable->with(['user', 'ukomBan'])->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->searchHas(ParticipantUkom::class, ['user', 'ukomBan']);
    }

    public function findSearchByNip(Pageable $pageable, $nip)
    {
        $pageable->addEqual("nip", $nip);
        $pageable->addEqual("delete_flag", false);
        return $pageable->with(['user'])->searchHas(ParticipantUkom::class, ['user']);
    }

    public function findByNipAndUkomId($nip, $ukom_id)
    {
        return ParticipantUkom::where('nip', $nip)->where('ukom_id', $ukom_id)->firstOrThrowNotFound();
    }

    public function findAllByNip($nip)
    {
        return ParticipantUkom::where('nip', $nip)->get();
    }

    public function findById($id)
    {
        return ParticipantUkom::findOrThrowNotFound($id);
    }

    public function findByUserId($user_id)
    {
        return ParticipantUkom::where("user_id", $user_id)
            ->where("inactive_flag", false)
            ->first();
    }

    public function findByNipOrEmail($user_id_or_email)
    {
        return ParticipantUkom::orWhere("nip", $user_id_or_email)
            ->orWhere("email", $user_id_or_email)
            ->where("inactive_flag", false)
            ->where("delete_flag", false)
            ->first();
    }

    public function findByRoomId($room_id)
    {
        return ParticipantRoomUkom::where("room_id", $room_id)->get()->map(function (ParticipantRoomUkom $participantRoomUkom) {
            return $participantRoomUkom->participantUkom;
        });
    }

    public function findLatestByNip($nip)
    {
        return ParticipantUkom::where('nip', $nip)
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->latest("date_created")->firstOrThrowNotFound();
    }

    public function save(ParticipantUkomDto $participantUkomDto): ParticipantUkom
    {
        return DB::transaction(function () use ($participantUkomDto) {
            $userContext = user_context();

            ParticipantUkom::where('nip', $participantUkomDto->nip)->update(['inactive_flag' => true]);

            $participantUkom = new ParticipantUkom();
            $participantUkom->fromArray($participantUkomDto->toArray());
            $participantUkom->created_by = $userContext->id;
            $participantUkom->id = $participantUkomDto->id;
            $participantUkom->save();

            $participantUkomDto->id = $participantUkom->id;
            $this->documentUkomService->save($participantUkomDto);

            return $participantUkom;
        });
    }

    public function updateRekomendasi($nip, $rekomendasi)
    {
        return DB::transaction(function () use ($nip, $rekomendasi) {
            $userContext = user_context();

            $participantUkom = $this->findLatestByNip($nip);
            $participantUkom->rekomendasi = $rekomendasi;
            $participantUkom->updated_by = $userContext->id;
            $participantUkom->save();

            return $participantUkom;
        });
    }

    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $this->findById($id)->delete();
        });
    }

    public function deleteByNip($nip)
    {
        DB::transaction(function () use ($nip) {
            $this->findLatestByNip($nip)->delete();
        });
    }
}
