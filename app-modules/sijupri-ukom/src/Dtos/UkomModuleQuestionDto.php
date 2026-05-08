<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class UkomModuleQuestionDto extends BaseDto
{
    public $id;
    public $exam_type;
    public $question;
    public $file_question;

    public $upload_soal_list;

    public $bidang_jabatan_id;

    public function validateUpload()
    {
        return $this->validate([
            'exam_type' => 'required|string',
            'file_question' => 'required|string'
        ]);
    }
}
