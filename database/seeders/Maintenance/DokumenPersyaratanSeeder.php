<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenPersyaratanSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_dokumen_persyaratan')->insert([
            [
                'created_at' => now(),
                'created_by' => "system",
                'identifier' => "formasi",
                'code' => 'surat_pengajuan_abk',
                'name' => 'Surat Pengajuan ABK',
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'identifier' => "formasi",
                'code' => 'struktur_organisasi',
                'name' => 'Struktur Organisasi',
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'identifier' => "formasi",
                'code' => 'daftar_susuan_pegawai',
                'name' => 'Daftar Susunan Pegawai',
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'identifier' => "formasi",
                'code' => 'rencana_pemenuhan_kebutuhan_pegawai',
                'name' => 'Rencana Pemenuhan Kebutuhan Pegawai',
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'identifier' => "formasi",
                'code' => 'potensi_uttp',
                'name' => 'Potensi UTTP',
            ],
        ]);
    }
}
