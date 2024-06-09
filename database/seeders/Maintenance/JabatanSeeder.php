<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_jabatan')->insert([
            [
                'code' => 'penera',
                'name' => 'Penera',
                'created_by' => "system",
                'type' => 'jf_kemetrologian',
                'bidang' => 'perdagangan',
                'urutan' => 1,
                'description' => 'jf kemetrologian penera'
            ],
            [
                'code' => 'pengamat_tera',
                'name' => 'Pengamat Tera',
                'created_by' => "system",
                'type' => 'jf_kemetrologian',
                'bidang' => 'perdagangan',
                'urutan' => 2,
                'description' => 'jf kemetrologian pengamat tera'
            ],
            [
                'code' => 'pranata_lab_kemetrologian',
                'name' => 'Pranata Lab Kemetrologian',
                'created_by' => "system",
                'type' => 'jf_kemetrologian',
                'bidang' => 'perdagangan',
                'urutan' => 3,
                'description' => 'jf kemetrologian pranata lab kemetrologian'
            ],
            [
                'code' => 'pengawas_kemetrologian',
                'name' => 'Pengawas Kemetrologian',
                'created_by' => "system",
                'type' => 'jf_kemetrologian',
                'bidang' => 'perdagangan',
                'urutan' => 4,
                'description' => 'jf kemetrologian pengawas'
            ],
            [
                'code' => 'penguji_mutu_barang',
                'name' => 'Penguji Mutu Barang',
                'created_by' => "system",
                'type' => 'jf_kemetrologian',
                'bidang' => 'perdagangan',
                'urutan' => 5,
                'description' => 'jf kemetrologian penguji mutu barang'
            ],
            [
                'code' => 'analis_investigasi_dan_pengamanan_perdagangan',
                'name' => 'Analis Investigasi dan Pengamanan Perdagangan',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 6,
                'description' => 'jf external analis investigasi dan pengamanan perdagangan'
            ],
            [
                'code' => 'negosiator_perdagangan',
                'name' => 'Negosiator Perdagangan',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 7,
                'description' => 'jf external negosiator perdagangan'
            ],
            [
                'code' => 'pengawas_perdagangan',
                'name' => 'Pengawas Perdagangan',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 8,
                'description' => 'jf external pengawas perdagangan'
            ],
            [
                'code' => 'pemeriksa_perdagangan_berjangka_komoditi',
                'name' => 'Pemeriksa Perdagangan Berjangka Komoditi',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 9,
                'description' => 'jf external pemeriksa perdagangan berjangka komoditi'
            ],
            [
                'code' => 'penjamin_mutu_produk',
                'name' => 'Penjamin Mutu Produk',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 10,
                'description' => 'jf external penjamin mutu produk'
            ],
            [
                'code' => 'analis_perdagangan',
                'name' => 'Analis Perdagangan',
                'created_by' => "system",
                'type' => 'jf_external',
                'bidang' => 'perdagangan',
                'urutan' => 11,
                'description' => 'jf external analis perdagangan'
            ]
        ]);
    }
}
