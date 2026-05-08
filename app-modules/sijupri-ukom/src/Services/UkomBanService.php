<?php

namespace Eyegil\SijupriUkom\Services;

use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\Base\Exceptions\RecordExistException;
use Eyegil\SijupriMaintenance\Services\SystemConfigurationService;
use Eyegil\SijupriUkom\Dtos\UkomBanDto;
use Eyegil\SijupriUkom\Models\UkomBan;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class UkomBanService
{
    public function __construct(
        private SystemConfigurationService $systemConfigurationService,
        private ParticipantRoomUkomService $participantRoomUkomService,
        private ParticipantUkomService $participantUkomService,
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.until', 'asc');
            }
        })->searchHas(UkomBan::class, ['user']);
    }

    public function findById($id)
    {
        return UkomBan::find($id);
    }

    public function findByNip($nip)
    {
        UkomBan::find($nip);
    }

    public function banMe($key)
    {
        return DB::transaction(function () use ($key) {
            $participant_id = Crypt::decrypt($key);
            $participantUkom = $this->participantUkomService->findById($participant_id);

            $sysConf = $this->systemConfigurationService->findByCode("UKM_BAN");
            $days = (int) $sysConf->value;

            $ukomBan = UkomBan::find($participantUkom->nip);
            if (!$ukomBan) {
                $ukomBan = new UkomBan();
                $ukomBan->id = $participantUkom->nip;
            }

            $participantUkom->inactive_flag = true;
            $participantUkom->save();
            // $this->participantRoomUkomService->deleteByParticipantId($participant_id);

            return $ukomBan;
        });
    }

    public function banByParticipantId($participant_id)
    {
        return DB::transaction(function () use ($participant_id) {
            $participantUkom = $this->participantUkomService->findById($participant_id);

            $sysConf = $this->systemConfigurationService->findByCode("UKM_BAN_FAILED");
            $days = (int) $sysConf->value;

            $ukomBan = UkomBan::find($participantUkom->nip);
            if (!$ukomBan) {
                $ukomBan = new UkomBan();
                $ukomBan->id = $participantUkom->nip;
            }
            $ukomBan->until = Carbon::now()->addDays($days);
            $ukomBan->save();

            // $this->participantRoomUkomService->deleteByParticipantId($participant_id);

            return $ukomBan;
        });
    }

    public function ban(UkomBanDto $ukomBanDto)
    {
        DB::transaction(function () use ($ukomBanDto) {
            if ($this->findById($ukomBanDto->id)) {
                throw new RecordExistException("nip already banned");
            }

            $ukomBan = UkomBan::find($ukomBanDto->id);
            if (!$ukomBan) {
                $ukomBan = new UkomBan();
                $ukomBan->id = $ukomBanDto->id;
            }
            $ukomBan->until = Carbon::parse($ukomBanDto->until);
            $ukomBan->save();
        });
    }

    public function editBan(UkomBanDto $ukomBanDto)
    {
        DB::transaction(function () use ($ukomBanDto) {
            $ukomBan = $this->findById($ukomBanDto->id);
            if (!$ukomBan) {
                throw new RecordNotFoundException("nip not found");
            }
            $ukomBan->until = Carbon::parse($ukomBanDto->until);
            $ukomBan->save();
        });
    }

    public function unBan($nip)
    {
        DB::transaction(function () use ($nip) {
            $ukomBan = $this->findById($nip);
            if (!$ukomBan) {
                return;
            }
            $ukomBan->delete();
        });
    }

    public function deleteExpiredBan()
    {
        DB::transaction(function () {
            UkomBan::where('until', '<=', Carbon::now())->delete();
        });
    }
}
