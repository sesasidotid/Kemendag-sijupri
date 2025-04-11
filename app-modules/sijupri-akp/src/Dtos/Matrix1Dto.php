<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class Matrix1Dto extends BaseDto
{
    public $id;
    public $nilai_ybs;
    public $nilai_atasan;
    public $nilai_rekan;
    public $score;
    public $keterangan;
    public $pertanyaan_id;
    public $pertanyaan_name;
    public $matrix_id;
}
