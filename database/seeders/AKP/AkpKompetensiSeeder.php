<?php

namespace Database\Seeders\AKP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkpKompetensiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_akp_kompetensi')->insert([
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan identifikasi dan verifikasi data dan informasi terkait dengan kebijakan Ekspor/Impor',
                'description' => 'Kemampuan melakukan identifikasi dan verifikasi data dan informasi terkait dengan kebijakan Ekspor/Impor',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis data dan informasi yang digunakan dalam penghitungan alokasi ekspor impor untuk produk tertentu',
                'description' => 'Kemampuan menganalisis data dan informasi yang digunakan dalam penghitungan alokasi ekspor impor untuk produk tertentu',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan memberikan konsultasi kepada masyarakat dan stakeholder tentang kebijakan ekspor/impor',
                'description' => 'Kemampuan memberikan konsultasi kepada masyarakat dan stakeholder tentang kebijakan ekspor/impor',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis permasalahan teknis perdagangan dalam bidang ekspor dan impor.',
                'description' => 'Kemampuan menganalisis permasalahan teknis perdagangan dalam bidang ekspor dan impor.',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis faktor-faktor yang mempengaruhi implementasi kebijakan bidang pengelolaan ekspor dan impor',
                'description' => 'Kemampuan menganalisis faktor-faktor yang mempengaruhi implementasi kebijakan bidang pengelolaan ekspor dan impor',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan memeriksa kelengkapan dokumen pemohon sesuai dengan jenis permohonan perizinan atau non perizinan perdagangan dan mengidentifikasi jika ada data dan informasi yang tidak lengkap/sesuai;',
                'description' => 'Kemampuan memeriksa kelengkapan dokumen pemohon sesuai dengan jenis permohonan perizinan atau non perizinan perdagangan dan mengidentifikasi jika ada data dan informasi yang tidak lengkap/sesuai;',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menyajikan hasil analisis dan menjelaskan secara lengkap, rinci dan jelas terhadap hasil  analisis kelayakan penerbitan dokumen perizinan/non perizinan bidang perdagangan',
                'description' => 'Kemampuan menyajikan hasil analisis dan menjelaskan secara lengkap, rinci dan jelas terhadap hasil  analisis kelayakan penerbitan dokumen perizinan/non perizinan bidang perdagangan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menyusun laporan hasil analisis kelayakan penerbitan dokumen perizinan/non perizinan bidang perdagangan; ',
                'description' => 'Kemampuan menyusun laporan hasil analisis kelayakan penerbitan dokumen perizinan/non perizinan bidang perdagangan; ',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan pembaruan data dan informasi terkait perizinan atau non perizinan bidang perdagangan',
                'description' => 'Kemampuan melakukan pembaruan data dan informasi terkait perizinan atau non perizinan bidang perdagangan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan pemantauan harga atau stok barang pokok dan barang penting sesuai dengan prosedur yang ditetapkan',
                'description' => 'Kemampuan melakukan pemantauan harga atau stok barang pokok dan barang penting sesuai dengan prosedur yang ditetapkan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan analisis hasil Pemantauan Harga dan Pasokan/Stok Barang Kebutuhan Pokok dan Barang Penting dan menyajikan informasi kepada pihak internal',
                'description' => 'Kemampuan melakukan analisis hasil Pemantauan Harga dan Pasokan/Stok Barang Kebutuhan Pokok dan Barang Penting dan menyajikan informasi kepada pihak internal',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan analisis data dan informasi terkait jaringan distribusi, sarana perdagangan dan logistic dan potensi, kebutuhan dan perhitungan pembiayaan pembangunan/revitalisasi sarana perdagangan serta analisis pemberdayaan dan peningkatan kualitas pengelolaan pasar rakyat',
                'description' => 'Kemampuan melakukan analisis data dan informasi terkait jaringan distribusi, sarana perdagangan dan logistic dan potensi, kebutuhan dan perhitungan pembiayaan pembangunan/revitalisasi sarana perdagangan serta analisis pemberdayaan dan peningkatan kualitas pengelolaan pasar rakyat',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan mengidentifikasi target dan komoditas kegiatan stabilitasi harga dan ketersediaan bahan pokok dan barang penting',
                'description' => 'Kemampuan mengidentifikasi target dan komoditas kegiatan stabilitasi harga dan ketersediaan bahan pokok dan barang penting',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melakukan verifikasi  data harga dan stok /pasokan barang kebutuhan pokok dan barang penting',
                'description' => 'Kemampuan melakukan verifikasi  data harga dan stok /pasokan barang kebutuhan pokok dan barang penting',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis dan memberikan masukan dalam rangka penyempurnaan bahan pelaksanaan kegiatan pelaksanaan pemberdayaan konsumen dan pembinaan pelaku usaha',
                'description' => 'Kemampuan menganalisis dan memberikan masukan dalam rangka penyempurnaan bahan pelaksanaan kegiatan pelaksanaan pemberdayaan konsumen dan pembinaan pelaku usaha',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menyusun rencana kegiatan pemberdayaan konsumen dan pembinaan pelaku berdasarkan target yang telah ditetapkan',
                'description' => 'Kemampuan menyusun rencana kegiatan pemberdayaan konsumen dan pembinaan pelaku berdasarkan target yang telah ditetapkan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan memberikan informasi yang relevan dalam rangka pemberian layanan konsultasi dan informasi di bidang pemberdayaan konsumen dan pembinaan pelaku usaha',
                'description' => 'Kemampuan memberikan informasi yang relevan dalam rangka pemberian layanan konsultasi dan informasi di bidang pemberdayaan konsumen dan pembinaan pelaku usaha',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melaksanakan pelayanan pengaduan dan membantu penyelesaian pengaduan konsumen melalui klarifikasi pelaku usaha dan mediasi antara pelaku usaha dan konsumen',
                'description' => 'Kemampuan melaksanakan pelayanan pengaduan dan membantu penyelesaian pengaduan konsumen melalui klarifikasi pelaku usaha dan mediasi antara pelaku usaha dan konsumen',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan melaksanakan pelaporan terkait pelayanan dan pembaharuan data pada kegiatan yang memenuhi hasil kerja minimal di bidang pemberdayaan konsumen dan pembinaan pelaku usaha',
                'description' => 'Kemampuan melaksanakan pelaporan terkait pelayanan dan pembaharuan data pada kegiatan yang memenuhi hasil kerja minimal di bidang pemberdayaan konsumen dan pembinaan pelaku usaha',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan mengidentifikasi kualitas produk dalam negeri yang memenuhi standar ekspor dan mencocokkan dengan kebutuhan pasar',
                'description' => 'Kemampuan mengidentifikasi kualitas produk dalam negeri yang memenuhi standar ekspor dan mencocokkan dengan kebutuhan pasar',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis data dan informasi produk unggulan daerah/potensial ekspor dan pangsa pasar lokal/pasar tujuan ekspor dan memberikan masukan dalam rangka perbaikan',
                'description' => 'Kemampuan menganalisis data dan informasi produk unggulan daerah/potensial ekspor dan pangsa pasar lokal/pasar tujuan ekspor dan memberikan masukan dalam rangka perbaikan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menyajikan data dan informasi terkait pengusaha/produsen/ekportir yang memenuhi standar untuk mengikuti kegiatan promosi perdagangan dan/ atau pemetaan produk unggulan daerah/potensial ekspor dan pangsa pasar lokal/pasar tujuan ekspor',
                'description' => 'Kemampuan menyajikan data dan informasi terkait pengusaha/produsen/ekportir yang memenuhi standar untuk mengikuti kegiatan promosi perdagangan dan/ atau pemetaan produk unggulan daerah/potensial ekspor dan pangsa pasar lokal/pasar tujuan ekspor',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan memberikan informasi kepada pemangku kepentingan terkait kegiatan promosi perdagangan yang diselenggarakan Kementerian Perdagangan',
                'description' => 'Kemampuan memberikan informasi kepada pemangku kepentingan terkait kegiatan promosi perdagangan yang diselenggarakan Kementerian Perdagangan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan mempersiapkan pelaksanaan promosi perdagangan, meliputi pengecekan lokasi, sarana dan prasarana, seleksi dan penentuan peserta, serta mengkoordinasikan pelaksanaan promosi dengan pihak-pihak terkait',
                'description' => 'Kemampuan mempersiapkan pelaksanaan promosi perdagangan, meliputi pengecekan lokasi, sarana dan prasarana, seleksi dan penentuan peserta, serta mengkoordinasikan pelaksanaan promosi dengan pihak-pihak terkait',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menyusun laporan pelaksanaan kegiatan promosi perdagangan sesuai dengan prosedur.',
                'description' => 'Kemampuan menyusun laporan pelaksanaan kegiatan promosi perdagangan sesuai dengan prosedur.',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Kemampuan menganalisis data dan informasi transaksi hasil promosi perdagangan atau misi pembelian',
                'description' => 'Kemampuan menganalisis data dan informasi transaksi hasil promosi perdagangan atau misi pembelian',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Mampu menganalisis dan memverifikasi data dan informasi perdagangan yang menjadi kewenangannya dan memberikan masukan dalam rangka perbaikan',
                'description' => 'Mampu menganalisis dan memverifikasi data dan informasi perdagangan yang menjadi kewenangannya dan memberikan masukan dalam rangka perbaikan',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Mampu menentukan format/ tampilan penyajian data dan informasi yang akan ditampilkan di website',
                'description' => 'Mampu menentukan format/ tampilan penyajian data dan informasi yang akan ditampilkan di website',
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'name' => 'Mampu memberikan informasi yang relevan kepada masyarakat dan stakeholder tentang data dan informasi perdagangan yang menjadi kewenangannya',
                'description' => 'Mampu memberikan informasi yang relevan kepada masyarakat dan stakeholder tentang data dan informasi perdagangan yang menjadi kewenangannya',
            ],
        ]);
    }
}
