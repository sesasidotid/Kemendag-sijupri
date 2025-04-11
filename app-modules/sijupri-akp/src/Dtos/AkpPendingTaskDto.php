<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class AkpPendingTaskDto extends BaseDto
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

    public $date_created;
    public $created_by;
    public $last_updated;
    public $updated_by;

    public $nip;
    public $name;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin_code;
    public $jenis_kelamin_name;
    public $unit_kerja_id;
    public $unit_kerja_name;
    public $instansi_id;
    public $instansi_name;
    public $pangkat_code;
    public $pangkat_name;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;

    public $akp_id;
    public $instrument_id;
    public $instrument_name;
    public $nama_atasan;
    public $email_atasan;
    public $action;
    public $rekomendasi;
    public $rekomendasi_url;
    public $rekomendasi_file;
    public array $matrix1_dto_list;
    public array $matrix2_dto_list;
    public array $matrix3_dto_list;
    public array $akp_rekap_dto_list;
}
