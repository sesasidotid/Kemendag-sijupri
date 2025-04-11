<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ParticipantUkomPendingTaskDto extends BaseDto
{
    public $id;
    public $object_id;
    public $object_name;
    public $object_group;
    public $comment;
    public $task_type;
    public $task_action;
    public $task_status;
    public $workflow_name;
    public $workflow_template;
    public $flow_name;
    public $flow_id;
    public $remark;
    public $instance_id;
    public $workflow_id;
    public $object_task_id;
    public $pending_task_history;

    public $participant_ukom_id;
    public $nip;
    public $name;
    public $phone;
    public $email;
    public $age;
    public $tanggal_lahir;
    public $participant_status;

    public $jenis_instansi;
    public $provinsi_id;
    public $provinsi_name;
    public $kabupaten_kota_id;
    public $kabupaten_kota_name;

    public $no_surat_usulan;
    public $tgl_surat_usulan;
    public $pendidikan_terakhir_code;
    public $pendidikan_terakhir_name;
    public $jurusan;
    public $predikat_kinerja_1_id;
    public $predikat_kinerja_1_name;
    public $predikat_kinerja_2_id;
    public $predikat_kinerja_2_name;
    public $is_mengulang;

    public $jenis_ukom;
    public $pangkat_code;
    public $pangkat_name;
    public $jabatan_name;
    public $jenjang_name;
    public $rekomendasi;
    public $rekomendasi_url;
    public $rekomendasi_file;
    public $next_jabatan_code;
    public $next_jabatan_name;
    public $next_jenjang_code;
    public $next_jenjang_name;
    public $bidang_jabatan_code;
    public $bidang_jabatan_name;
    public $unit_kerja_id;
    public $unit_kerja_name;
    public $ukom_id;

    public array $dokumen_ukom_list;
}
