<?php

namespace Eyegil\SijupriAkp\Dtos;

use Eyegil\Base\Dtos\BaseDto;

class AkpRekapDto extends BaseDto
{
    public $id;
    public $keterangan;
    public $penyebab_diskrepansi_utama;
    public $jenis_pengembangan_kompetensi;
    public $kategori;
    public $rank_prioritas;
    public $dokumen_verifikasi;
    public $dokumen_verifikasi_url;
    public $file_dokumen_verifikasi;
    public $verified;
    public $pelatihan_teknis_id;
    public $pelatihan_teknis_name;
    public $pertanyaan_id;
    public $pertanyaan_name;
    public $matrix_id;
    public $remark;

    public function validateUploadProof()
    {
        return $this->validate([
            'id' => 'required',
            'file_dokumen_verifikasi' => 'required'
        ]);
    }

    public function validateDokumenVerifikasi()
    {
        return $this->validate([
            'id' => 'required',
            'verified' => 'required'
        ]);
    }
}
