<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_instansi')->insert([
            [
                'name' => 'BKPSDM Provinsi',
                'description' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Provinsi',
                'tipe_instansi_code' => 'provinsi',
                'created_by' => "system",
            ],
            [
                'name' => 'BKD Provinsi',
                'description' => 'Badan Kepegawaian Daerah Provinsi',
                'tipe_instansi_code' => 'provinsi',
                'created_by' => "system",
            ],


            [
                'name' => 'BKPSDM Kabupaten',
                'description' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kabupaten',
                'tipe_instansi_code' => 'kabupaten',
                'created_by' => "system",
            ],
            [
                'name' => 'BKD Kabupaten',
                'description' => 'Badan Kepegawaian Daerah Kabupaten',
                'tipe_instansi_code' => 'kabupaten',
                'created_by' => "system",
            ],


            [
                'name' => 'BKPSDM Kota',
                'description' => 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Kota',
                'tipe_instansi_code' => 'kota',
                'created_by' => "system",
            ],
            [
                'name' => 'BKD Kota',
                'description' => 'Badan Kepegawaian Daerah Kota',
                'tipe_instansi_code' => 'kota',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Koordinator Bidang Politik, Hukum, dan Keamanan',
                'description' => 'Kementerian Koordinator Bidang Politik, Hukum, dan Keamanan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Koordinator Bidang Perekonomian',
                'description' => 'Kementerian Koordinator Bidang Perekonomian',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan',
                'description' => 'Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Koordinator Bidang Kemaritiman dan Investasi',
                'description' => 'Kementerian Koordinator Bidang Kemaritiman dan Investasi',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Luar Negeri',
                'description' => 'Kementerian Luar Negeri',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Kesehatan',
                'description' => 'Kementerian Kesehatan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Perindustrian ',
                'description' => 'Kementerian Perindustrian ',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Energi dan Sumber Daya Mineral',
                'description' => 'Kementerian Energi dan Sumber Daya Mineral',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'description' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Perhubungan',
                'description' => 'Kementerian Perhubungan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Komunikasi dan Informatika',
                'description' => 'Kementerian Komunikasi dan Informatika',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Pertanian',
                'description' => 'Kementerian Pertanian',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Lingkungan Hidup dan Kehutanan',
                'description' => 'Kementerian Lingkungan Hidup dan Kehutanan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Kelautan dan Perikanan',
                'description' => 'Kementerian Kelautan dan Perikanan',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Koperasi dan Usaha Kecil dan Menengah',
                'description' => 'Kementerian Koperasi dan Usaha Kecil dan Menengah',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Pariwisata dan Ekonomi Kreatif / Badan Pariwisata dan Ekonomi Kreatif',
                'description' => 'Kementerian Pariwisata dan Ekonomi Kreatif / Badan Pariwisata dan Ekonomi Kreatif',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Kementerian Riset dan Teknologi / Badan Riset dan Inovasi Nasional',
                'description' => 'Kementerian Riset dan Teknologi / Badan Riset dan Inovasi Nasional',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Pariwisata dan Ekonomi Kreatif',
                'description' => 'Badan Pariwisata dan Ekonomi Kreatif',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Koordinasi Penanaman Modal (BKPM)',
                'description' => 'Badan Koordinasi Penanaman Modal (BKPM)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Narkotika Nasional (BNN)',
                'description' => 'Badan Narkotika Nasional (BNN)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Pengawas Tenaga Nuklir (BAPETEN)',
                'description' => 'Badan Pengawas Tenaga Nuklir (BAPETEN)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Pengawasan Obat dan Makanan (BPOM)',
                'description' => 'Badan Pengawasan Obat dan Makanan (BPOM)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Standardisasi Nasional (BSN)',
                'description' => 'Badan Standardisasi Nasional (BSN)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Badan Riset dan Inovasi Nasional (BRIN)',
                'description' => 'Badan Riset dan Inovasi Nasional (BRIN)',
                'tipe_instansi_code' => 'kementerian_lembaga',
                'created_by' => "system",
            ],
            [
                'name' => 'Pusat Pembinaan Jabatan Fungsional Perdagangan',
                'description' => 'Pusat Pembinaan Jabatan Fungsional Perdagangan',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Direktorat Jenderal Perdagangan Dalam Negeri',
                'description' => 'Sekretariat Direktorat Jenderal Perdagangan Dalam Negeri',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Direktorat Jenderal Perdagangan Perlindungan Konsumen dan Tertib Niaga',
                'description' => 'Sekretariat Direktorat Jenderal Perdagangan Perlindungan Konsumen dan Tertib Niaga',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Direktorat Jenderal Perdagangan Luar Negeri',
                'description' => 'Sekretariat Direktorat Jenderal Perdagangan Luar Negeri',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Direktorat Jenderal Perundingan Perdagangan Internasional',
                'description' => 'Sekretariat Direktorat Jenderal Perundingan Perdagangan Internasional',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Direktorat Jenderal Pengembangan Ekspor Nasional',
                'description' => 'Sekretariat Direktorat Jenderal Pengembangan Ekspor Nasional',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Badan Kebijakan Perdagangan',
                'description' => 'Sekretariat Badan Kebijakan Perdagangan',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
            [
                'name' => 'Sekretariat Badan Pengawas Perdagangan Berjangka Komoditi',
                'description' => 'Sekretariat Badan Pengawas Perdagangan Berjangka Komoditi',
                'tipe_instansi_code' => 'pusbin',
                'created_by' => "system",
            ],
        ]);
    }
}
