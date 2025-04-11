<?php

namespace Eyegil\SijupriFormasi\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class FormasiResultDto extends BaseDto
{
    public $id;
    public $sdm;
    public $pembulatan;
    public $result;
    public $total;
    public $jenjang_code;
    public $jenjang_name;
    public $formasi_detail_id;



    public function validateUpdateResult()
    {
        return $this->validate([
            "id" => "required"
        ]);
    }
}
