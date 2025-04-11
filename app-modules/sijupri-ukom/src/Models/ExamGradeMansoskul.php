<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamGradeMansoskul extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_grade_mansoskul';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string"])]
    private $exam_type_mansoskul_code;

    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;

    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_id;

    #[Column(["type" => "double", "default" => 0])]
    private $score;

    protected $fillable = ['id', 'room_ukom_id', 'exam_type_code', 'participant_ukom'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
}
