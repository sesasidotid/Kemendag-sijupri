<?php

namespace Eyegil\SijupriUkom\Models;

use Eyegil\Base\Commons\Migration\Column;
use Eyegil\Base\Models\Updatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkomGrade extends Updatable
{
    use HasFactory;

    protected $table = 'ukm_grade';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $keyType = 'string';

    #[Column(["type" => "string", "primary" => true])]
    private $id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_cat;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $cat_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_wawancara;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $wawancara_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_seminar;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $makalah_grade_id;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $seminar_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_praktik;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $praktik_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_portofolio;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $portofolio_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $nb_studi_kasus;
    #[Column(["type" => "string", "nullable" => true, "foreign" => ExamGrade::class])]
    private $studi_kasus_grade_id;



    #[Column(["type" => "double", "nullable" => true])]
    private $jpm;
    #[Column(["type" => "double", "nullable" => true])]
    private $score;
    #[Column(["type" => "double", "nullable" => true])]
    private $ukt;
    #[Column(["type" => "double", "nullable" => true])]
    private $nb_ukt;
    #[Column(["type" => "double", "nullable" => true])]
    private $ukmsk;
    #[Column(["type" => "double", "nullable" => true])]
    private $weight;
    #[Column(["type" => "double", "nullable" => true])]
    private $grade;
    #[Column(["type" => "boolean", "default" => false])]
    private $passed;
    #[Column(["type" => "string", "nullable" => false])]
    private $status;
    #[Column(["type" => "string", "foreign" => RoomUkom::class])]
    private $room_ukom_id;
    #[Column(["type" => "string", "foreign" => ParticipantUkom::class, 'cascade' => ['DELETE']])]
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

    public function makalahGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'makalah_grade_id', 'id');
    }

    public function praktikGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'praktik_grade_id', 'id');
    }

    public function portofolioGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'portofolio_grade_id', 'id');
    }

    public function studiKasusGrade()
    {
        return $this->belongsTo(ExamGrade::class, 'studi_kasus_grade_id', 'id');
    }

    public function participantUkom()
    {
        return $this->belongsTo(ParticipantUkom::class, 'participant_id', 'id');
    }

    public function roomUkom()
    {
        return $this->belongsTo(RoomUkom::class, 'room_ukom_id', 'id');
    }
}
