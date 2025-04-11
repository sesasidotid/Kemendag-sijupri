<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Creatable;
use Eyegil\EyegilLms\Models\QuestionGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkomGrade extends Creatable
{
    use HasFactory;

    protected $table = 'ukm_grade';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;



    #[Column(["type" => "double", "default" => 0])]
    private $nb_cat;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $cat_grade_id;



    #[Column(["type" => "double", "default" => 0])]
    private $nb_wawancara;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $wawancara_grade_id;



    #[Column(["type" => "double", "default" => 0])]
    private $nb_seminar;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $seminar_grade_id;



    #[Column(["type" => "double", "default" => 0])]
    private $nb_praktik;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $praktik_grade_id;



    #[Column(["type" => "double", "default" => 0])]
    private $nb_portofolio;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $portofolio_grade_id;



    #[Column(["type" => "double", "default" => 0])]
    private $jpm;
    #[Column(["type" => "double", "default" => 0])]
    private $score;
    #[Column(["type" => "double", "default" => 0])]
    private $ukt;
    #[Column(["type" => "double", "default" => 0])]
    private $nb_ukt;
    #[Column(["type" => "double", "default" => 0])]
    private $ukmsk;
    #[Column(["type" => "double", "default" => 0])]
    private $weight;
    #[Column(["type" => "double", "default" => 0])]
    private $grade;
    #[Column(["type" => "boolean", "default" => false])]
    private $passed;
    #[Column(["type" => "string", "nullable" => false])]
    private $status;
    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class])]
    private $participant_id;

    protected $fillable = ['id', 'room_ukom_id', 'exam_type_code', 'participant_ukom'];
    public function __construct()
    {
        $this->fillable = array_merge($this->fillable, parent::getFillable());
    }

    public function catGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'cat_grade_id', 'id');
    }

    public function wawancaraGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'wawancara_grade_id', 'id');
    }

    public function seminarGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'seminar_grade_id', 'id');
    }

    public function praktikGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'praktik_grade_id', 'id');
    }

    public function portofolioGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'portofolio_grade_id', 'id');
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, 'participant_id', 'id');
    }

    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, 'room_ukom_id', 'id');
    }

    public function examQuestionList()
    {
        return $this->hasMany(ExamQuestion::class, 'exam_type_code', 'exam_type_code')
            ->whereColumn('ukm_exam_question.room_ukom_id', 'room_ukom_id');
    }
}
