<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Illuminate\Http\Request;

class RiwayatKinerjaDto extends BaseDto
{
    public $id;
    public $type;
    public $date_start;
    public $date_end;
    public $angka_kredit;
    public $doc_evaluasi;
    public $doc_evaluasi_url;
    public $file_doc_evaluasi;
    public $doc_predikat;
    public $doc_predikat_url;
    public $file_doc_predikat;
    public $doc_akumulasi_ak;
    public $doc_akumulasi_ak_url;
    public $file_doc_akumulasi_ak;
    public $doc_penetapan_ak;
    public $doc_penetapan_ak_url;
    public $file_doc_penetapan_ak;

    public $rating_hasil_id;
    public $rating_hasil_name;
    public $rating_hasil_value;

    public $rating_kinerja_id;
    public $rating_kinerja_name;
    public $rating_kinerja_value;

    public $predikat_kinerja_id;
    public $predikat_kinerja_name;
    public $predikat_kinerja_value;
    public $nip;

    public function validateSave()
    {
        return $this->validate([
            'type' => 'required|string',
            'date_start' => 'required|string',
            'date_end' => 'required|string',
            'angka_kredit' => 'required|numeric',
            'file_doc_evaluasi' => 'required',
            'file_doc_predikat' => 'required',
            'file_doc_akumulasi_ak' => 'required',
            'file_doc_penetapan_ak' => 'required',
            'rating_hasil_id' => 'required',
            'rating_kinerja_id' => 'required',
            'predikat_kinerja_id' => 'required',
        ]);
    }
}
