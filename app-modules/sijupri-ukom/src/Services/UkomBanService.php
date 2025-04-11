<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Eyegil\SijupriUkom\Models\UkomBan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UkomBanService
{
    public function __construct(
        private SystemConfigurationService $systemConfigurationService,
        private ParticipantRoomUkomService $participantRoomUkomService
    ) {}

    public function findById($id): UkomBan
    {
        return UkomBan::findOrThrowNotFound($id);
    }

    public function findByParticipantUkomId($participant_ukom_id)
    {
        UkomBan::find($participant_ukom_id);
    }

    public function banMe($key)
    {
        return DB::transaction(function () use ($key) {
            $participant_id = Crypt::decrypt($key);
            $sysConf = $this->systemConfigurationService->findByCode("UKM_BAN");
            $days = (int) $sysConf->value;

            $ukomBan = new UkomBan();
            $ukomBan->id = $participant_id;
            $ukomBan->until = Carbon::now()->addDays($days);
            $ukomBan->save();

            $this->participantRoomUkomService->deleteByParticipantId($participant_id);

            return $ukomBan;
        });
    }

    public function banByParticipantId($participant_id)
    {
        return DB::transaction(function () use ($participant_id) {
            $sysConf = $this->systemConfigurationService->findByCode("UKM_BAN_FAILED");
            $days = (int) $sysConf->value;

            $ukomBan = new UkomBan();
            $ukomBan->id = $participant_id;
            $ukomBan->until = Carbon::now()->addDays($days);
            $ukomBan->save();

            $this->participantRoomUkomService->deleteByParticipantId($participant_id);

            return $ukomBan;
        });
    }


    public function unBan($participant_ukom_id)
    {
        DB::transaction(function () use ($participant_ukom_id) {
            $participantRoomUkom = $this->findById($participant_ukom_id);
            $participantRoomUkom->delete();
        });
    }

    public function deleteExpiredBan()
    {
        DB::transaction(function () {
            UkomBan::where('until', '<=', Carbon::now())->delete();
        });
    }
}
