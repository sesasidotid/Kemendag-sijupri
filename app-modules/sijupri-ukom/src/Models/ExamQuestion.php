<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\EyegilLms\Models\Question;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamQuestion extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_exam_question';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;
    
    #[Column(["type" => "string", "foreign" => Question::class])]
    private $question_id;
    
    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;
    
    #[Column(["type" => "string", "foreign" => ExamType::class])]
    private $exam_type_code;

    protected $fillable = ['id', 'question_id', 'room_ukom_id', 'exam_type_code'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }
    
    public function question()
    {
        return $this->belongsTo(Question::class, "question_id", "id");
    }
    
    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class, "question_id", "question_id");
    }
    
    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, "room_ukom_id", "id");
    }
    
    public function examType()
    {
        return $this->belongsTo(ExamType::class, "exam_type_code", "code");
    }
}
