<?php

namespace Eyegil\SijupriSiap\Converters;

use Eyegil\SijupriSiap\Dtos\JFDto;
use Eyegil\SijupriSiap\Models\JF;


class JFConverter
{
    public static function toDto(JF $jf): JFDto
    {
        $jfDto = new JFDto();
        $jfDto->fromArray($jf->toArray());

        $jfDto->name = $jf->user->name;
        $jfDto->email = $jf->user->email;
        $jfDto->phone = $jf->user->phone;
        $jfDto->jenis_kelamin_name = optional($jf->jenisKelamin)->name;

        $jfDto->unit_kerja_id = optional($jf->unitKerja)->id;
        $jfDto->unit_kerja_name = optional($jf->unitKerja)->name;

        $jfDto->instansi_id = optional(optional($jf->unitKerja)->instansi)->id;
        $jfDto->instansi_name = optional(optional($jf->unitKerja)->instansi)->name;

        $pangkat = optional($jf->riwayatPangkat)->pangkat;
        $jfDto->pangkat_code = optional($pangkat)->code;
        $jfDto->pangkat_name = optional($pangkat)->name;

        $jabatan = optional($jf->riwayatJabatan)->jabatan;
        $jfDto->jabatan_code = optional($jabatan)->code;
        $jfDto->jabatan_name = optional($jabatan)->name;

        $jenjang = optional($jf->riwayatJabatan)->jenjang;
        $jfDto->jenjang_code = optional($jenjang)->code;
        $jfDto->jenjang_name = optional($jenjang)->name;

        return $jfDto;
    }
}
