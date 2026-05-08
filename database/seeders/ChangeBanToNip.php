<?php

namespace Database\Seeders;

use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\SijupriUkom\Models\UkomBan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChangeBanToNip extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $ukomBanList = UkomBan::all();
            foreach ($ukomBanList as $ban) {
                $participantUkom = ParticipantUkom::find($ban->id);
                if (UkomBan::where("id", $participantUkom->nip)->exists()) {
                    $ban->delete();
                } else {
                    $ban->id = $participantUkom->nip;
                    $ban->save();
                }
            }
        });
    }
}
