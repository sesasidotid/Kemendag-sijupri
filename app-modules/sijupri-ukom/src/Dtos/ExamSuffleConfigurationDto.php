<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class ExamSuffleConfigurationDto extends BaseDto
{
    public $id;
    public $exam_configuration_id;
    public $num_of_question;

    public $kompetensi_indikator_id;

    public $kompetensi_indikator_name;
}
