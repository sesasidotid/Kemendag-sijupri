<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParticipantRoomUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_participant_room';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_id;
    #[Column(["type" => "string", "foreign" => RoomUkom::class, 'cascade' => ['DELETE']])]
    private $room_id;

    protected $fillable = ['id', 'phone', 'name', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, "participant_id", "id");
    }

    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, "room_id", "id");
    }

    public function examScheduleList()
    {
        return $this->belongsTo(ExamSchedule::class, "room_id", "room_ukom_id");
    }
}
