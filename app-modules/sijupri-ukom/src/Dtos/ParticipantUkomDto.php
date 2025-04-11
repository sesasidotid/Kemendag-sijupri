<?php

namespace Eyegil\SijupriUkom\Dtos;

use Eyegil\SecurityBase\Dtos\UserDto;
use Eyegil\SijupriUkom\Enums\JenisUkom;

class ParticipantUkomDto extends UserDto
{
    public $id;
    public $nip;
    public $name;
    public $phone;
    public $email;
    public $age;
    public $tanggal_lahir;
    public $participant_status;

    public $jenis_instansi;
    public $provinsi_id;
    public $provinsi_name;
    public $kabupaten_kota_id;
    public $kabupaten_kota_name;


    public $no_surat_usulan;
    public $tgl_surat_usulan;
    public $pendidikan_terakhir_code;
    public $pendidikan_terakhir_name;
    public $jurusan;
    public $predikat_kinerja_1_id;
    public $predikat_kinerja_1_name;
    public $predikat_kinerja_2_id;
    public $predikat_kinerja_2_name;
    public $is_mengulang;


    public $jenis_ukom;
    public $rekomendasi;
    public $rekomendasi_url;
    public $rekomendasi_file;
    public $pangkat_code;
    public $pangkat_name;
    public $jabatan_name;
    public $jenjang_name;
    public $next_jabatan_code;
    public $next_jabatan_name;
    public $next_jenjang_code;
    public $next_jenjang_name;
    public $bidang_jabatan_code;
    public $bidang_jabatan_name;
    public $unit_kerja_id;
    public $unit_kerja_name;
    public $user_id;

    public array $dokumen_ukom_list;

    public $ukom_ban_dto;

    public $room_ukom_dto;

    public function validateSaveWithJF()
    {

        $this->validate([
            'jenis_ukom' => 'required|string',
            "password" => "required|string"
        ]);

        if ($this->jenis_ukom == JenisUkom::KENAIKAN_JENJANG->value) {
            return $this->validate([
                'dokumen_ukom_list' => 'required|array',
            ]);
        } else if ($this->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
            return $this->validate([
                'next_jabatan_code' => 'required|string',
                'next_jenjang_code' => 'required|string',
                'dokumen_ukom_list' => 'required|array',
            "password" => "required|string",
            ]);
        }
    }

    public function validateSaveParticipant()
    {

        $this->validate([
            'jenis_ukom' => 'required|string',
            "password" => "required|string"
        ]);

        if ($this->jenis_ukom == JenisUkom::PERPINDAHAN_JABATAN->value) {
            return $this->validate([
                "nip" => "required|string",
                "name" => "required|string",
                "email" => "required|string",
                "unit_kerja_name" => "required|string",
                "jabatan_name" => "required|string",
                "jenjang_name" => "required|string",
                "next_jabatan_code" => "required|string",
                "next_jenjang_code" => "required|string",
                "dokumen_ukom_list" => "required|array",
            ]);
        } else if ($this->jenis_ukom == JenisUkom::PROMOSI->value) {
            return $this->validate([
                'nip' => 'required|string',
                'name' => 'required|string',
                'email' => 'required|string',
                "jabatan_name" => "required|string",
                "jenjang_name" => "required|string",
                "unit_kerja_name" => "required|string",
                'next_jabatan_code' => 'required|string',
                'next_jenjang_code' => 'required|string',
                'dokumen_ukom_list' => 'required|array',
            ]);
        }
    }

    public function validateFlow1Reject()
    {
        return $this->validate([
            "dokumen_ukom_list" => "required|array",
        ]);
    }
}
