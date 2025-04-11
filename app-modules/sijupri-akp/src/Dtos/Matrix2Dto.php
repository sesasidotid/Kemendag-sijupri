<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class Matrix2Dto extends BaseDto
{
    public $id;
    public $nilai_penugasan;
    public $nilai_materi;
    public $nilai_informasi;
    public $nilai_standar;
    public $nilai_metode;
    public $alasan_materi;
    public $alasan_informasi;
    public $penyebab_diskrepansi_utama;
    public $jenis_pengembangan_kompetensi;
    public $pertanyaan_id;
    public $pertanyaan_name;
    public $score;
    public $matrix_id;
}
