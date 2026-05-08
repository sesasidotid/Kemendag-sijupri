<?php

namespace Eyegil\SijupriSiap\Dtos;

use Eyegil\Base\Dtos\BaseDto;
use Eyegil\SijupriMaintenance\Models\KategoriSertifikasi;
use Illuminate\Http\Request;

class RiwayatSertifikasiDto extends BaseDto
{
    public $id;
    public $no_sk;
    public $tgl_sk;
    public $wilayah_kerja;
    public $date_start;
    public $date_end;
    public $uu_kawalan;
    public $sk_pengangkatan;
    public $sk_pengangkatan_url;
    public $file_sk_pengangkatan;
    public $ktp_ppns;
    public $ktp_ppns_url;
    public $file_ktp_ppns;
    public $kategori_sertifikasi_id;
    public $kategori_sertifikasi_name;
    public $kategori_sertifikasi_value;
    public $nip;

    public function validateSave()
    {
        $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($this->kategori_sertifikasi_id);
        if ($kategoriSertifikasi->value = 1) {
            return $this->validate([
                'no_sk' => 'required|string',
                'tgl_sk' => 'required|string',
                'file_sk_pengangkatan' => 'required|string',
                'kategori_sertifikasi_id' => 'required|string',
            ]);
        } else {
            return $this->validate([
                'no_sk' => 'required|string',
                'tgl_sk' => 'required|string',
                'wilayah_kerja' => 'required',
                'date_start' => 'required|string',
                'date_end' => 'required|string',
                'uu_kawalan' => 'required|string',
                'file_sk_pengangkatan' => 'required|string',
                'file_ktp_ppns' => 'required|string',
                'kategori_sertifikasi_id' => 'required|string',
            ]);
        }
    }

    public function validateTask()
    {
        $kategoriSertifikasi = KategoriSertifikasi::findOrThrowNotFound($this->kategori_sertifikasi_id);
        if ($kategoriSertifikasi->value = 1) {
            return $this->validate([
                'no_sk' => 'required',
                'tgl_sk' => 'required',
                'sk_pengangkatan_url' => 'required',
                'sk_pengangkatan' => 'required',
                'kategori_sertifikasi_id' => 'required',
                'kategori_sertifikasi_name' => 'required',
                'kategori_sertifikasi_value' => 'required',
                'nip' => 'required',
            ]);
        } else {
            return $this->validate([
                'no_sk' => 'required',
                'tgl_sk' => 'required',
                'wilayah_kerja' => 'required',
                'date_start' => 'required',
                'date_end' => 'required',
                'uu_kawalan' => 'required',
                'sk_pengangkatan_url' => 'required',
                'sk_pengangkatan' => 'required',
                'ktp_ppns_url' => 'required',
                'ktp_ppns' => 'required',
                'kategori_sertifikasi_id' => 'required',
                'kategori_sertifikasi_name' => 'required',
                'kategori_sertifikasi_value' => 'required',
                'nip' => 'required',
            ]);
        }
    }
}
