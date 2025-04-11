<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class MatrixDto extends BaseDto
{
    public $id;
    public $relevansi;
    public $idx;
    public $pertanyaan_id;
    public $pertanyaan_name;
    public $kategori_instrument_id;
    public $akp_id;
    public $matrix1_dto;
    public $matrix2_dto;
    public $matrix3_dto;
    public $akp_rekap_dto;
}
