<?php

namespace Eyegil\SijupriUkom\Converters;

use Carbon\Carbon;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Models\ParticipantUkom;

class ParticipantUkomConverter
{
    public static function toDto(ParticipantUkom $participantUkom): ParticipantUkomDto
    {
        $participantUkomDto = new ParticipantUkomDto();
        $participantUkomDto->fromModel($participantUkom);

        $participantUkomDto->next_jabatan_name = $participantUkom->nextJabatan->name;
        $participantUkomDto->next_jenjang_name = $participantUkom->nextJenjang->name;
        // $participantUkomDto->next_pangkat_name = $participantUkom->nextPangkat->name;
        if ($participantUkom->jabatan_code) {
            $participantUkomDto->jabatan_name = $participantUkom->jabatan->name;
        } else {
            $participantUkomDto->jabatan_name = $participantUkom->jabatan_name;
        }
        
        if ($participantUkom->jenjang_code) {
            $participantUkomDto->jenjang_name = $participantUkom->jenjang->name;
        } else {
            $participantUkomDto->jenjang_name = $participantUkom->jenjang_name;
        }

        if ($participantUkom->pangkat_code) {
            $participantUkomDto->pangkat_name = $participantUkom->pangkat->name;
        }

        if ($participantUkom->bidang_jabatan_code) {
            $participantUkomDto->bidang_jabatan_name = $participantUkom->bidangJabatan->name;
        }

        if ($participantUkomDto->tanggal_lahir) {
            $participantUkomDto->age = Carbon::parse($participantUkomDto->tanggal_lahir)->age;
        }

        if ($participantUkomDto->pendidikan_terakhir_code) {
            $participantUkomDto->pendidikan_terakhir_name = $participantUkom->pendidikanTerakhir->name;
        }

        if ($participantUkomDto->predikat_kinerja_1_id) {
            $participantUkomDto->predikat_kinerja_1_name = $participantUkom->predikatKinerja1->name;
        }

        if ($participantUkomDto->predikat_kinerja_2_id) {
            $participantUkomDto->predikat_kinerja_2_name = $participantUkom->predikatKinerja2->name;
        }

        if ($participantUkomDto->provinsi_id) {
            $participantUkomDto->provinsi_name = $participantUkom->provinsi->name;
        }

        if ($participantUkomDto->kabupaten_kota_id) {
            $participantUkomDto->kabupaten_kota_name = $participantUkom->kabupatenKota->name;
        }

        return $participantUkomDto;
    }

    public static function withRoomOrBan(ParticipantUkom $participantUkom): ParticipantUkomDto
    {
        $participantUkomDto = static::withRoom($participantUkom);

        $ukomBan = $participantUkom->ukomBan;
        if ($ukomBan) {
            $participantUkomDto->ukom_ban_dto = $ukomBan;
        }

        return $participantUkomDto;
    }

    public static function withRoom(ParticipantUkom $participantUkom): ParticipantUkomDto
    {
        $participantUkomDto = static::toDto($participantUkom);

        $roomUkom = optional($participantUkom->participantRoomUkom)->roomUkom;
        if ($roomUkom) {
            $participantUkomDto->room_ukom_dto = RoomUkomConverter::withSchedule($roomUkom);
        }

        return $participantUkomDto;
    }
}
