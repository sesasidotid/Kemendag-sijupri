<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExaminerRoomUkom extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_examiner_room';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    #[Column(["type" => "string", "foreign" => ExaminerUkom::class, 'cascade' => ['DELETE']])]
    private $examiner_id;
    #[Column(["type" => "string", "foreign" => RoomUkom::class, 'cascade' => ['DELETE']])]
    private $room_id;

    protected $fillable = ['id', 'phone', 'name', 'email', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin_code', 'nip'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function examinerUkom()
    {
        return $this->belongsTo(ExaminerUkom::class, "examiner_id", "id");
    }

    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, "room_id", "id");
    }
}
