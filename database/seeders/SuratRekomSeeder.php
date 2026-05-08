<?php

namespace Database\Seeders;

use Eyegil\SijupriMaintenance\Models\SuratRekomTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratRekomSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {

            SuratRekomTemplate::updateOrCreate(
                [
                    "code" => "REKOM_UKOM",
                ],
                [
                    "base_template" => '<!DOCTYPE html> <html lang="id"> <head> <meta charset="UTF-8" /> <title>Surat Rekomendasi</title> <style> @page { size: A4; margin: 12mm 15mm; } body { font-family: "Times New Roman", Times, serif; font-size: 11pt; line-height: 1.2; margin: 0; padding: 0; } .header { text-align: center; /* Task 1: Garis bawah double dihapus */ padding-bottom: 5px; margin-bottom: 10px; } .header img { width: 100%; height: auto; display: block; } .doc-title { text-align: center; margin: 10px 0; } .doc-title h3 { margin: 0; font-size: 12pt; /* Task 2: Underline dihapus, bold dipertahankan */ text-decoration: none; font-weight: bold; text-transform: uppercase; } .doc-title p { margin: 2px 0; } table { width: 100%; border-collapse: collapse; font-size: 10.5pt; } th, td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; } .signature-section { margin-top: 20px; } .signature-table { border: none; } .signature-table td { border: none; padding: 0; vertical-align: top; } .qr-box { width: 90px; height: 90px; border: 1px solid #000; text-align: center; font-size: 8pt; line-height: 90px; } .sig-gap { height: 75px; } .tembusan { margin-top: 15px; font-size: 9pt; line-height: 1.2; } </style> </head> <body> <div class="header"> <img src="data:image/png;base64,{{$kop_img}}"> </div> <div class="doc-title"> <h3>Surat Rekomendasi Hasil Uji Kompetensi</h3> <h3>Jabatan Fungsional {{$jabatan_tujuan}}</h3> <p>NOMOR: {{$num_code1}}/{{$num_code2}}/{{$num_code3}}/{{$num_code4}}/{{$bulan}}/{{$tahun}}</p> </div> <table> <tr> <th colspan="5" align="left" style="background-color: #f2f2f2;">KETERANGAN PERORANGAN</th> </tr> <tr> <td width="5%" align="center">1</td> <td width="35%">Nama</td> <td colspan="3">{{$name}}</td> </tr> <tr> <td align="center">2</td> <td>NIP</td> <td colspan="3">{{$nip}}</td> </tr> <tr> <td align="center">3</td> <td>Pangkat/Golongan Ruang/TMT</td> <td colspan="3">{{$pangkat}} / {{$golongan}} / {{$tmt_pangkat}}</td> </tr> <tr> <td align="center">4</td> <td>Pendidikan Tertinggi</td> <td colspan="3">{{$pendidikan}}</td> </tr> <tr> <td align="center">5</td> <td>Tempat dan Tanggal Lahir</td> <td colspan="3">{{$tempat_lahir}}, {{$tanggal_lahir}}</td> </tr> <tr> <td align="center">6</td> <td>Jabatan Fungsional/TMT</td> <td colspan="3">{{$jabatan_tujuan}} / {{$tmt_jabatan}}</td> </tr> <tr> <td align="center">7</td> <td>Unit Kerja</td> <td colspan="3">{{$unit_kerja_name}}</td> </tr> <tr> <td align="center">8</td> <td>Instansi</td> <td colspan="3">{{$instansi_name}}</td> </tr> <tr> <th colspan="5" align="center" style="background-color: #f2f2f2;">HASIL UJI KOMPETENSI</th> </tr> <tr align="center" style="font-weight: bold;"> <td width="5%">No</td> <td>Metode Uji Kompetensi</td> <td width="15%">Bobot</td> <td width="15%">Nilai</td> <td width="20%">Bobot x Nilai</td> </tr> <tr> <td align="center">1</td> <td>Uji Kompetensi Teknis</td> <td align="center">{{$teknis_percentage}}%</td> <td align="center">{{$nilai_teknis}}</td> <td align="center">{{$bobot_teknis}}</td> </tr> <tr> <td align="center">2</td> <td>Uji Kompetensi Manajerial dan Sosial Kultural</td> <td align="center">{{$mansoskul_percentage}}%</td> <td align="center">{{$nilai_manajerial}}</td> <td align="center">{{$bobot_manajerial}}</td> </tr> <tr> <td colspan="4" align="right"><strong>Nilai Akhir</strong></td> <td align="center"><strong>{{$nilai_akhir}}</strong></td> </tr> <tr> <th colspan="5" align="center" style="background-color: #f2f2f2;">REKOMENDASI</th> </tr> <tr> <td colspan="5" style="padding: 8px;"> 1. Lulus Uji Kompetensi untuk diangkat dalam Jabatan Fungsional {{$jabatan_tujuan}} Jenjang {{$jenjang_tujuan}}.<br /> 2. Surat Rekomendasi berlaku selama 2 (dua) tahun sejak ditetapkan. </td> </tr> </table> <div class="signature-section"> <table class="signature-table"> <tr> <td width="50%"> <div class="qr-box">QR Code</div> </td> <td width="50%" style="text-align: left; padding-left: 40px;"> Ditetapkan di {{$ditetapkan}}<br /> {{$tanggal}}<br /> {{$jabatan_penandatangan}}, <div class="sig-gap"></div> <strong><u>{{$nama_penandatangan}}</u></strong><br /> NIP. {{$nip_penandatangan}} </td> </tr> </table> </div> <div class="tembusan"> <strong>Tembusan disampaikan kepada:</strong><br /> 1. Pejabat Pembina Kepegawaian yang bersangkutan;<br /> 2. Pejabat Pimpinan Tinggi Pratama yang membidangi kepegawaian yang bersangkutan;<br /> 3. Pimpinan Unit Kerja yang bersangkutan. </div> </body> </html>',
                    "template" => "",
                ]
            );
        });
    }
}
