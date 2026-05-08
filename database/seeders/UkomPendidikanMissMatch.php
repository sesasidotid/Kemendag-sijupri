<?php

namespace Database\Seeders;

use Eyegil\SijupriSiap\Models\JF;
use Eyegil\SijupriUkom\Dtos\ParticipantUkomDto;
use Eyegil\SijupriUkom\Models\ParticipantUkom;
use Eyegil\WorkflowBase\Models\PendingTask;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UkomPendidikanMissMatch extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $participantUkomList = ParticipantUkom::where("participant_status", "jf")->get();
            foreach ($participantUkomList as $key => $participantUkom) {
                $jf = JF::find($participantUkom->nip);
                $riwayatPendidikan = $jf->riwayatPendidikan;
                if ($riwayatPendidikan) {
                    $participantUkom->pendidikan_terakhir_code = $riwayatPendidikan->pendidikan_code;
                    $participantUkom->save();
                }
            }

            $pendingTaskList = PendingTask::join('wf_object_task', function ($join) {
                $join->on('wf_pending_task.object_task_id', '=', 'wf_object_task.id');
                $join->where("wf_object_task.object->participant_status", "jf");
            })
                ->where("wf_pending_task.date_created", ">", "2025-09-01 00:00:00")
                ->get();

            foreach ($pendingTaskList as $key => $pendingTask) {
                $participantUkomData = (new ParticipantUkomDto())->fromArray((array) $pendingTask->objectTask->object)->toArray();
                if (!isset($participantUkomData['nip'])) {
                    Log::warning("NIP not found in wf_object_task: " . json_encode($participantUkomData));
                    continue;
                }

                $isUpdate = false;

                $jf = JF::find($participantUkomData['nip']);
                $riwayatPendidikan = $jf->riwayatPendidikan;
                if ($riwayatPendidikan) {
                    $participantUkomData['pendidikan_terakhir_code'] = $riwayatPendidikan->pendidikan_code;
                    $participantUkomData['pendidikan_terakhir_name'] = $riwayatPendidikan->pendidikan_name;
                    $objectTask = $pendingTask->objectTask;

                    $isUpdate = true;
                }

                $instansi = $jf->unitKerja->instansi;
                if ($instansi) {
                    $participantUkomData['instansi_id'] = $instansi->id ?? null;
                    $participantUkomData['provinsi_id'] = $instansi->provinsi_id ?? null;
                    $participantUkomData['kabupaten_kota_id'] = $instansi->kabupaten_id ?? $instansi->kota_id ?? null;

                    $isUpdate = true;
                }

                if (!$isUpdate) {
                    continue;
                }
                $objectTask->object = $participantUkomData;
                $objectTask->save();
            }
        });
    }
}
