<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UkomBanDto extends BaseDto
{
    public $id;
    public $name;
    public $until;

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
