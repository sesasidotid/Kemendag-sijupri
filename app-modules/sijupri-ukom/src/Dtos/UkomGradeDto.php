<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UkomGradeDto extends BaseDto
{
    
    public $id;

    public $nb_cat;
    public $cat_grade_id;
    public $cat_grade_score;

    public $nb_wawancara;
    public $wawancara_grade_id;
    public $wawancara_grade_score;

    public $nb_seminar;
    public $seminar_grade_id;
    public $seminar_grade_score;

    public $nb_praktik;
    public $praktik_grade_id;
    public $praktik_grade_score;

    public $nb_portofolio;
    public $portofolio_grade_id;
    public $portofolio_grade_score;

    public $jpm;
    public $score;
    public $ukt;
    public $nb_ukt;
    public $ukmsk;
    public $weight;
    public $grade;
    public $passed;
    public $status;
    public $room_ukom_id;
    public $room_ukom_name;
    public $participant_id;
    public $participant_name;
    public $nip;
}
