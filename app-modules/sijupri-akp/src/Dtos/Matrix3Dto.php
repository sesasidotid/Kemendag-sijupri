<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class Matrix3Dto extends BaseDto
{
    public $id;
    public $nilai_waktu;
    public $nilai_kesulitan;
    public $nilai_kualitas;
    public $nilai_pengaruh;
    public $nilai_metode;
    public $kategori;
    public $rank_prioritas;
    public $pertanyaan_id;
    public $pertanyaan_name;
    public $score;
    public $matrix_id;
}
