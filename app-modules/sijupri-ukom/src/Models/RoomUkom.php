<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Eyegil\SijupriMaintenance\Models\BidangJabatan;
use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_room';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string"])]
    private $name;
    #[Column(["type" => "integer"])]
    private $participant_quota;
    #[Column(["type" => "timestamp"])]
    private $exam_start_at;
    #[Column(["type" => "timestamp"])]
    private $exam_end_at;
    #[Column(["type" => "string"])]
    private $vid_call_link;
    #[Column(["type" => "string", "foreign" => Jabatan::class])]
    private $jabatan_code;
    #[Column(["type" => "string", "foreign" => Jenjang::class])]
    private $jenjang_code;
    #[Column(["type" => "string", "nullable" => true, "foreign" => BidangJabatan::class])]
    private $bidang_jabatan_code;

    protected $fillable = ['id', 'name', 'jabatan_code', 'jenjang_code', 'bidang_jabatan_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantRoomUkomList()
    {
        $this->hasMany(ParticipantRoomUkom::class, "room_id", "id");
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_code', 'code');
    }
    public function jenjang()
    {
        return $this->belongsTo(Jenjang::class, 'jenjang_code', 'code');
    }

    public function bidangJabatan()
    {
        return $this->belongsTo(BidangJabatan::class, 'bidang_jabatan_code', 'code');
    }

    public function examScheduleList()
    {
        return $this->hasMany(ExamSchedule::class, 'room_ukom_id', 'id');
    }
}
