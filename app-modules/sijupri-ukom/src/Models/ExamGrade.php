<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamGrade extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_grade';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;

    #[Column(["type" => "string", "foreign" => ExamType::class])]
    private $exam_type_code;

    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;

    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
    private $participant_id;

    #[Column(["type" => "double", "default" => 0])]
    private $score;

    protected $fillable = ['id', 'exam_type_code', 'room_ukom_id', 'participant_id', 'score'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function examQuestionList()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_type_code', 'exam_type_code')
            ->whereColumn('ukm_exam_question.room_ukom_id', 'room_ukom_id');
    }
}
