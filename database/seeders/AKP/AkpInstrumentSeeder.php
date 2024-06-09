<?php

namespace Database\Seeders\AKP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AkpInstrumentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_akp_instrumen')->insert([
            [
                'name' => "AKP Penjamin Mutu Produk Ahli Pertama",
                'description' => "AKP Penjamin Mutu Produk",
                'jabatan_code' => 'penjamin_mutu_produk',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Penjamin Mutu Produk Ahli Muda",
                'description' => "AKP Penjamin Mutu Produk",
                'jabatan_code' => 'penjamin_mutu_produk',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Penjamin Mutu Produk Ahli Madya",
                'description' => "AKP Penjamin Mutu Produk",
                'jabatan_code' => 'penjamin_mutu_produk',
                'jenjang_code' => 'madya',
            ],
            [
                'name' => "Penguji Mutu Barang",
                'description' => "Penguji Mutu Barang",
                'jabatan_code' => 'penguji_mutu_barang',
                'jenjang_code' => 'pemula',
            ],
            [
                'name' => "AKP Pengawas Perdagangan Pertama",
                'description' => "AKP Pengawas Perdagangan",
                'jabatan_code' => 'pengawas_perdagangan',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Pengawas Perdagangan Muda",
                'description' => "AKP Pengawas Perdagangan",
                'jabatan_code' => 'pengawas_perdagangan',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Pengawas Perdagangan Madya",
                'description' => "AKP Pengawas Perdagangan",
                'jabatan_code' => 'pengawas_perdagangan',
                'jenjang_code' => 'madya',
            ],
            [
                'name' => "AKP Penera Terampil",
                'description' => "AKP Penera",
                'jabatan_code' => 'penera',
                'jenjang_code' => 'penyelia',
            ],
            [
                'name' => "AKP Penera Pertama",
                'description' => "AKP Penera",
                'jabatan_code' => 'penera',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Penera Muda",
                'description' => "AKP Penera",
                'jabatan_code' => 'penera',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Pemeriksa PPBK Ahli Pertama",
                'description' => "Pemeriksa PPBK",
                'jabatan_code' => 'pemeriksa_perdagangan_berjangka_komoditi',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Pemeriksa PPBK Ahli Muda",
                'description' => "Pemeriksa PPBK",
                'jabatan_code' => 'pemeriksa_perdagangan_berjangka_komoditi',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Pemeriksa PPBK Ahli Madya",
                'description' => "Pemeriksa PPBK",
                'jabatan_code' => 'pemeriksa_perdagangan_berjangka_komoditi',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Negosiator Perdaganhan Ahli Pertama",
                'description' => "Negosiator Perdaganan",
                'jabatan_code' => 'negosiator_perdagangan',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Negosiator Perdaganhan Ahli Muda",
                'description' => "Negosiator Perdaganan",
                'jabatan_code' => 'negosiator_perdagangan',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Negosiator Perdaganhan Ahli Madya",
                'description' => "Negosiator Perdaganan",
                'jabatan_code' => 'negosiator_perdagangan',
                'jenjang_code' => 'madya',
            ],
            [
                'name' => "AKP Analis Perdaganan Ahli Pertama",
                'description' => "Analisis Perdaganan",
                'jabatan_code' => 'analis_perdagangan',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP Analis Perdaganan Ahli Muda",
                'description' => "Analisis Perdaganan",
                'jabatan_code' => 'analis_perdagangan',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP Analis Perdaganan Ahli Madya",
                'description' => "Analisis Perdaganan",
                'jabatan_code' => 'analis_perdagangan',
                'jenjang_code' => 'madya',
            ],
            [
                'name' => "AKP AIPP Ahli Pertama",
                'description' => "AIPP",
                'jabatan_code' => 'analis_investigasi_dan_pengamanan_perdagangan',
                'jenjang_code' => 'pertama',
            ],
            [
                'name' => "AKP AIPP Ahli Muda",
                'description' => "AIPP",
                'jabatan_code' => 'analis_investigasi_dan_pengamanan_perdagangan',
                'jenjang_code' => 'muda',
            ],
            [
                'name' => "AKP AIPP Ahli Madya",
                'description' => "AIPP",
                'jabatan_code' => 'analis_investigasi_dan_pengamanan_perdagangan',
                'jenjang_code' => 'madya',
            ],
        ]);
    }
}
