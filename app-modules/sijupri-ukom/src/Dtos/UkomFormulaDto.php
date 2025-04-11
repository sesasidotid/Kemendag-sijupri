<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UkomFormulaDto extends BaseDto
{
    public $id;
    public $jabatan_code;
    public $jabatan_name;
    public $jenjang_code;
    public $jenjang_name;
    public $cat_percentage;
    public $wawancara_percentage;
    public $seminar_percentage;
    public $praktik_percentage;
    public $portofolio_percentage;
    public $ukt_percentage;
    public $ukmsk_percentage;
    public $grade_threshold;
    public $ukt_threshold;
    public $jpm_threshold;

    public function validateUpdate()
    {
        return $this->validate([
            "id" => "required",
            "cat_percentage" => "required",
            "wawancara_percentage" => "required",
            "seminar_percentage" => "required",
            "praktik_percentage" => "required",
            "portofolio_percentage" => "required",
            "ukt_percentage" => "required",
            "ukmsk_percentage" => "required",
            "grade_threshold" => "required",
            "ukt_threshold" => "required",
            "jpm_threshold" => "required",
        ]);
    }
}
