<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabKotaSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_kab_kota')->insert([
            [
                'id' => 1101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIMEULUE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIMEULUE",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH SINGKIL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH SINGKIL",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH SELATAN",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH TENGGARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH TENGGARA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH TIMUR",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH TENGAH",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH BARAT",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH BESAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH BESAR",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1109,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PIDIE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PIDIE",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1110,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BIREUEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BIREUEN",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1111,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH UTARA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1112,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH BARAT DAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH BARAT DAYA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1113,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GAYO LUES",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GAYO LUES",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1114,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH TAMIANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH TAMIANG",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1115,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NAGAN RAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NAGAN RAYA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1116,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ACEH JAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ACEH JAYA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1117,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENER MERIAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENER MERIAH",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1118,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PIDIE JAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PIDIE JAYA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANDA ACEH",
                'type' => 'KOTA',
                'description' => "KOTA BANDA ACEH",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SABANG",
                'type' => 'KOTA',
                'description' => "KOTA SABANG",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1173,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA LANGSA",
                'type' => 'KOTA',
                'description' => "KOTA LANGSA",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1174,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA LHOKSEUMAWE",
                'type' => 'KOTA',
                'description' => "KOTA LHOKSEUMAWE",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1175,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SUBULUSSALAM",
                'type' => 'KOTA',
                'description' => "KOTA SUBULUSSALAM",
                'provinsi_id' => (int)"11"
            ],
            [
                'id' => 1201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NIAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NIAS",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANDAILING NATAL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANDAILING NATAL",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAPANULI SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAPANULI SELATAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAPANULI TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAPANULI TENGAH",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAPANULI UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAPANULI UTARA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TOBA SAMOSIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TOBA SAMOSIR",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LABUHAN BATU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LABUHAN BATU",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ASAHAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ASAHAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1209,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIMALUNGUN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIMALUNGUN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1210,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DAIRI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DAIRI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1211,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KARO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KARO",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1212,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DELI SERDANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DELI SERDANG",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1213,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LANGKAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LANGKAT",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1214,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NIAS SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NIAS SELATAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1215,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HUMBANG HASUNDUTAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HUMBANG HASUNDUTAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1216,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PAKPAK BHARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PAKPAK BHARAT",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1217,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SAMOSIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SAMOSIR",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1218,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SERDANG BEDAGAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SERDANG BEDAGAI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1219,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BATU BARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BATU BARA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1220,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PADANG LAWAS UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PADANG LAWAS UTARA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1221,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PADANG LAWAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PADANG LAWAS",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1222,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LABUHAN BATU SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LABUHAN BATU SELATAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1223,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LABUHAN BATU UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LABUHAN BATU UTARA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1224,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NIAS UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NIAS UTARA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1225,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NIAS BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NIAS BARAT",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SIBOLGA",
                'type' => 'KOTA',
                'description' => "KOTA SIBOLGA",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1272,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TANJUNG BALAI",
                'type' => 'KOTA',
                'description' => "KOTA TANJUNG BALAI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1273,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PEMATANG SIANTAR",
                'type' => 'KOTA',
                'description' => "KOTA PEMATANG SIANTAR",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1274,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TEBING TINGGI",
                'type' => 'KOTA',
                'description' => "KOTA TEBING TINGGI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1275,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MEDAN",
                'type' => 'KOTA',
                'description' => "KOTA MEDAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1276,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BINJAI",
                'type' => 'KOTA',
                'description' => "KOTA BINJAI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1277,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PADANGSIDIMPUAN",
                'type' => 'KOTA',
                'description' => "KOTA PADANGSIDIMPUAN",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1278,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA GUNUNGSITOLI",
                'type' => 'KOTA',
                'description' => "KOTA GUNUNGSITOLI",
                'provinsi_id' => (int)"12"
            ],
            [
                'id' => 1301,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN MENTAWAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN MENTAWAI",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1302,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PESISIR SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PESISIR SELATAN",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1303,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SOLOK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SOLOK",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1304,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIJUNJUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIJUNJUNG",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1305,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANAH DATAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANAH DATAR",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1306,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PADANG PARIAMAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PADANG PARIAMAN",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1307,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN AGAM",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN AGAM",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1308,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LIMA PULUH KOTA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LIMA PULUH KOTA",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1309,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PASAMAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PASAMAN",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1310,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SOLOK SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SOLOK SELATAN",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1311,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DHARMASRAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DHARMASRAYA",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1312,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PASAMAN BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PASAMAN BARAT",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1371,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PADANG",
                'type' => 'KOTA',
                'description' => "KOTA PADANG",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1372,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SOLOK",
                'type' => 'KOTA',
                'description' => "KOTA SOLOK",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1373,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SAWAH LUNTO",
                'type' => 'KOTA',
                'description' => "KOTA SAWAH LUNTO",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1374,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PADANG PANJANG",
                'type' => 'KOTA',
                'description' => "KOTA PADANG PANJANG",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1375,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BUKITTINGGI",
                'type' => 'KOTA',
                'description' => "KOTA BUKITTINGGI",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1376,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PAYAKUMBUH",
                'type' => 'KOTA',
                'description' => "KOTA PAYAKUMBUH",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1377,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PARIAMAN",
                'type' => 'KOTA',
                'description' => "KOTA PARIAMAN",
                'provinsi_id' => (int)"13"
            ],
            [
                'id' => 1401,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUANTAN SINGINGI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUANTAN SINGINGI",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1402,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN INDRAGIRI HULU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN INDRAGIRI HULU",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1403,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN INDRAGIRI HILIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN INDRAGIRI HILIR",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1404,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PELALAWAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PELALAWAN",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1405,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN S I A K",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN S I A K",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1406,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAMPAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAMPAR",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1407,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ROKAN HULU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ROKAN HULU",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1408,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENGKALIS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENGKALIS",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1409,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ROKAN HILIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ROKAN HILIR",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1410,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN MERANTI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN MERANTI",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1471,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PEKANBARU",
                'type' => 'KOTA',
                'description' => "KOTA PEKANBARU",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1473,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA D U M A I",
                'type' => 'KOTA',
                'description' => "KOTA D U M A I",
                'provinsi_id' => (int)"14"
            ],
            [
                'id' => 1501,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KERINCI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KERINCI",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1502,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MERANGIN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MERANGIN",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1503,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SAROLANGUN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SAROLANGUN",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1504,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BATANG HARI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BATANG HARI",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1505,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUARO JAMBI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUARO JAMBI",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1506,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANJUNG JABUNG TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANJUNG JABUNG TIMUR",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1507,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANJUNG JABUNG BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANJUNG JABUNG BARAT",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1508,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TEBO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TEBO",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1509,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUNGO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUNGO",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1571,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAMBI",
                'type' => 'KOTA',
                'description' => "KOTA JAMBI",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1572,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SUNGAI PENUH",
                'type' => 'KOTA',
                'description' => "KOTA SUNGAI PENUH",
                'provinsi_id' => (int)"15"
            ],
            [
                'id' => 1601,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN OGAN KOMERING ULU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN OGAN KOMERING ULU",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1602,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN OGAN KOMERING ILIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN OGAN KOMERING ILIR",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1603,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUARA ENIM",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUARA ENIM",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1604,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAHAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAHAT",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1605,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUSI RAWAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUSI RAWAS",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1606,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUSI BANYUASIN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUSI BANYUASIN",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1607,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANYU ASIN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANYU ASIN",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1608,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN OGAN KOMERING ULU SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN OGAN KOMERING ULU SELATAN",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1609,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN OGAN KOMERING ULU TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN OGAN KOMERING ULU TIMUR",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1610,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN OGAN ILIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN OGAN ILIR",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1611,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN EMPAT LAWANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN EMPAT LAWANG",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1612,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PENUKAL ABAB LEMATANG ILIR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PENUKAL ABAB LEMATANG ILIR",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1613,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUSI RAWAS UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUSI RAWAS UTARA",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1671,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PALEMBANG",
                'type' => 'KOTA',
                'description' => "KOTA PALEMBANG",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1672,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PRABUMULIH",
                'type' => 'KOTA',
                'description' => "KOTA PRABUMULIH",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1673,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PAGAR ALAM",
                'type' => 'KOTA',
                'description' => "KOTA PAGAR ALAM",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1674,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA LUBUKLINGGAU",
                'type' => 'KOTA',
                'description' => "KOTA LUBUKLINGGAU",
                'provinsi_id' => (int)"16"
            ],
            [
                'id' => 1701,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENGKULU SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENGKULU SELATAN",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1702,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN REJANG LEBONG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN REJANG LEBONG",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1703,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENGKULU UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENGKULU UTARA",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1704,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAUR",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1705,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SELUMA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SELUMA",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1706,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUKOMUKO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUKOMUKO",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1707,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LEBONG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LEBONG",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1708,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPAHIANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPAHIANG",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1709,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENGKULU TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENGKULU TENGAH",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1771,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BENGKULU",
                'type' => 'KOTA',
                'description' => "KOTA BENGKULU",
                'provinsi_id' => (int)"17"
            ],
            [
                'id' => 1801,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMPUNG BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMPUNG BARAT",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1802,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANGGAMUS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANGGAMUS",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1803,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMPUNG SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMPUNG SELATAN",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1804,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMPUNG TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMPUNG TIMUR",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1805,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMPUNG TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMPUNG TENGAH",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1806,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMPUNG UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMPUNG UTARA",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1807,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WAY KANAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WAY KANAN",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1808,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TULANGBAWANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TULANGBAWANG",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1809,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PESAWARAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PESAWARAN",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1810,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PRINGSEWU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PRINGSEWU",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1811,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MESUJI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MESUJI",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1812,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TULANG BAWANG BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TULANG BAWANG BARAT",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1813,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PESISIR BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PESISIR BARAT",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1871,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANDAR LAMPUNG",
                'type' => 'KOTA',
                'description' => "KOTA BANDAR LAMPUNG",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1872,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA METRO",
                'type' => 'KOTA',
                'description' => "KOTA METRO",
                'provinsi_id' => (int)"18"
            ],
            [
                'id' => 1901,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGKA",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1902,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BELITUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BELITUNG",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1903,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGKA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGKA BARAT",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1904,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGKA TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGKA TENGAH",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1905,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGKA SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGKA SELATAN",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1906,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BELITUNG TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BELITUNG TIMUR",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 1971,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PANGKAL PINANG",
                'type' => 'KOTA',
                'description' => "KOTA PANGKAL PINANG",
                'provinsi_id' => (int)"19"
            ],
            [
                'id' => 2101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KARIMUN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KARIMUN",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BINTAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BINTAN",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NATUNA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NATUNA",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LINGGA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LINGGA",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN ANAMBAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN ANAMBAS",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA B A T A M",
                'type' => 'KOTA',
                'description' => "KOTA B A T A M",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 2172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TANJUNG PINANG",
                'type' => 'KOTA',
                'description' => "KOTA TANJUNG PINANG",
                'provinsi_id' => (int)"21"
            ],
            [
                'id' => 3101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN SERIBU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN SERIBU",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAKARTA SELATAN",
                'type' => 'KOTA',
                'description' => "KOTA JAKARTA SELATAN",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAKARTA TIMUR",
                'type' => 'KOTA',
                'description' => "KOTA JAKARTA TIMUR",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3173,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAKARTA PUSAT",
                'type' => 'KOTA',
                'description' => "KOTA JAKARTA PUSAT",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3174,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAKARTA BARAT",
                'type' => 'KOTA',
                'description' => "KOTA JAKARTA BARAT",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3175,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAKARTA UTARA",
                'type' => 'KOTA',
                'description' => "KOTA JAKARTA UTARA",
                'provinsi_id' => (int)"31"
            ],
            [
                'id' => 3201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOGOR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOGOR",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUKABUMI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUKABUMI",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN CIANJUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN CIANJUR",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANDUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANDUNG",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GARUT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GARUT",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TASIKMALAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TASIKMALAYA",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN CIAMIS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN CIAMIS",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUNINGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUNINGAN",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3209,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN CIREBON",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN CIREBON",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3210,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAJALENGKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAJALENGKA",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3211,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMEDANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMEDANG",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3212,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN INDRAMAYU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN INDRAMAYU",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3213,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUBANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUBANG",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3214,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PURWAKARTA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PURWAKARTA",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3215,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KARAWANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KARAWANG",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3216,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BEKASI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BEKASI",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3217,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANDUNG BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANDUNG BARAT",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3218,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PANGANDARAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PANGANDARAN",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BOGOR",
                'type' => 'KOTA',
                'description' => "KOTA BOGOR",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3272,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SUKABUMI",
                'type' => 'KOTA',
                'description' => "KOTA SUKABUMI",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3273,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANDUNG",
                'type' => 'KOTA',
                'description' => "KOTA BANDUNG",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3274,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA CIREBON",
                'type' => 'KOTA',
                'description' => "KOTA CIREBON",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3275,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BEKASI",
                'type' => 'KOTA',
                'description' => "KOTA BEKASI",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3276,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA DEPOK",
                'type' => 'KOTA',
                'description' => "KOTA DEPOK",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3277,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA CIMAHI",
                'type' => 'KOTA',
                'description' => "KOTA CIMAHI",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3278,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TASIKMALAYA",
                'type' => 'KOTA',
                'description' => "KOTA TASIKMALAYA",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3279,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANJAR",
                'type' => 'KOTA',
                'description' => "KOTA BANJAR",
                'provinsi_id' => (int)"32"
            ],
            [
                'id' => 3301,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN CILACAP",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN CILACAP",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3302,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANYUMAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANYUMAS",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3303,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PURBALINGGA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PURBALINGGA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3304,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANJARNEGARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANJARNEGARA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3305,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEBUMEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEBUMEN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3306,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PURWOREJO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PURWOREJO",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3307,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WONOSOBO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WONOSOBO",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3308,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAGELANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAGELANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3309,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOYOLALI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOYOLALI",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3310,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KLATEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KLATEN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3311,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUKOHARJO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUKOHARJO",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3312,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WONOGIRI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WONOGIRI",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3313,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KARANGANYAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KARANGANYAR",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3314,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SRAGEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SRAGEN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3315,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GROBOGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GROBOGAN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3316,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BLORA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BLORA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3317,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN REMBANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN REMBANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3318,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PATI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PATI",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3319,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUDUS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUDUS",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3320,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JEPARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JEPARA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3321,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DEMAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DEMAK",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3322,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SEMARANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SEMARANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3323,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TEMANGGUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TEMANGGUNG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3324,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KENDAL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KENDAL",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3325,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BATANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BATANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3326,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PEKALONGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PEKALONGAN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3327,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PEMALANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PEMALANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3328,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TEGAL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TEGAL",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3329,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BREBES",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BREBES",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3371,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MAGELANG",
                'type' => 'KOTA',
                'description' => "KOTA MAGELANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3372,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SURAKARTA",
                'type' => 'KOTA',
                'description' => "KOTA SURAKARTA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3373,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SALATIGA",
                'type' => 'KOTA',
                'description' => "KOTA SALATIGA",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3374,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SEMARANG",
                'type' => 'KOTA',
                'description' => "KOTA SEMARANG",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3375,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PEKALONGAN",
                'type' => 'KOTA',
                'description' => "KOTA PEKALONGAN",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3376,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TEGAL",
                'type' => 'KOTA',
                'description' => "KOTA TEGAL",
                'provinsi_id' => (int)"33"
            ],
            [
                'id' => 3401,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KULON PROGO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KULON PROGO",
                'provinsi_id' => (int)"34"
            ],
            [
                'id' => 3402,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANTUL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANTUL",
                'provinsi_id' => (int)"34"
            ],
            [
                'id' => 3403,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GUNUNG KIDUL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GUNUNG KIDUL",
                'provinsi_id' => (int)"34"
            ],
            [
                'id' => 3404,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SLEMAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SLEMAN",
                'provinsi_id' => (int)"34"
            ],
            [
                'id' => 3471,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA YOGYAKARTA",
                'type' => 'KOTA',
                'description' => "KOTA YOGYAKARTA",
                'provinsi_id' => (int)"34"
            ],
            [
                'id' => 3501,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PACITAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PACITAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3502,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PONOROGO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PONOROGO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3503,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TRENGGALEK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TRENGGALEK",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3504,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TULUNGAGUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TULUNGAGUNG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3505,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BLITAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BLITAR",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3506,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEDIRI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEDIRI",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3507,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALANG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3508,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LUMAJANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LUMAJANG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3509,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JEMBER",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JEMBER",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3510,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANYUWANGI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANYUWANGI",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3511,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BONDOWOSO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BONDOWOSO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3512,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SITUBONDO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SITUBONDO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3513,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PROBOLINGGO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PROBOLINGGO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3514,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PASURUAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PASURUAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3515,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIDOARJO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIDOARJO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3516,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MOJOKERTO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MOJOKERTO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3517,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JOMBANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JOMBANG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3518,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NGANJUK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NGANJUK",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3519,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MADIUN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MADIUN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3520,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAGETAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAGETAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3521,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NGAWI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NGAWI",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3522,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOJONEGORO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOJONEGORO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3523,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TUBAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TUBAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3524,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMONGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMONGAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3525,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GRESIK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GRESIK",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3526,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGKALAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGKALAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3527,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SAMPANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SAMPANG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3528,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PAMEKASAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PAMEKASAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3529,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMENEP",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMENEP",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3571,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA KEDIRI",
                'type' => 'KOTA',
                'description' => "KOTA KEDIRI",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3572,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BLITAR",
                'type' => 'KOTA',
                'description' => "KOTA BLITAR",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3573,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MALANG",
                'type' => 'KOTA',
                'description' => "KOTA MALANG",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3574,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PROBOLINGGO",
                'type' => 'KOTA',
                'description' => "KOTA PROBOLINGGO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3575,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PASURUAN",
                'type' => 'KOTA',
                'description' => "KOTA PASURUAN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3576,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MOJOKERTO",
                'type' => 'KOTA',
                'description' => "KOTA MOJOKERTO",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3577,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MADIUN",
                'type' => 'KOTA',
                'description' => "KOTA MADIUN",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3578,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SURABAYA",
                'type' => 'KOTA',
                'description' => "KOTA SURABAYA",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3579,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BATU",
                'type' => 'KOTA',
                'description' => "KOTA BATU",
                'provinsi_id' => (int)"35"
            ],
            [
                'id' => 3601,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PANDEGLANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PANDEGLANG",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3602,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LEBAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LEBAK",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3603,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANGERANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANGERANG",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3604,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SERANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SERANG",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3671,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TANGERANG",
                'type' => 'KOTA',
                'description' => "KOTA TANGERANG",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3672,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA CILEGON",
                'type' => 'KOTA',
                'description' => "KOTA CILEGON",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3673,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SERANG",
                'type' => 'KOTA',
                'description' => "KOTA SERANG",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 3674,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TANGERANG SELATAN",
                'type' => 'KOTA',
                'description' => "KOTA TANGERANG SELATAN",
                'provinsi_id' => (int)"36"
            ],
            [
                'id' => 5101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JEMBRANA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JEMBRANA",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TABANAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TABANAN",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BADUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BADUNG",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GIANYAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GIANYAR",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KLUNGKUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KLUNGKUNG",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGLI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGLI",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KARANG ASEM",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KARANG ASEM",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BULELENG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BULELENG",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA DENPASAR",
                'type' => 'KOTA',
                'description' => "KOTA DENPASAR",
                'provinsi_id' => (int)"51"
            ],
            [
                'id' => 5201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LOMBOK BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LOMBOK BARAT",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LOMBOK TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LOMBOK TENGAH",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LOMBOK TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LOMBOK TIMUR",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBAWA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBAWA",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DOMPU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DOMPU",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BIMA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BIMA",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBAWA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBAWA BARAT",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LOMBOK UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LOMBOK UTARA",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MATARAM",
                'type' => 'KOTA',
                'description' => "KOTA MATARAM",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5272,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BIMA",
                'type' => 'KOTA',
                'description' => "KOTA BIMA",
                'provinsi_id' => (int)"52"
            ],
            [
                'id' => 5301,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBA BARAT",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5302,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBA TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBA TIMUR",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5303,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUPANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUPANG",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5304,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TIMOR TENGAH SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TIMOR TENGAH SELATAN",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5305,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TIMOR TENGAH UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TIMOR TENGAH UTARA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5306,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BELU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BELU",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5307,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ALOR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ALOR",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5308,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LEMBATA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LEMBATA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5309,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN FLORES TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN FLORES TIMUR",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5310,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIKKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIKKA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5311,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ENDE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ENDE",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5312,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NGADA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NGADA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5313,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANGGARAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANGGARAI",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5314,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ROTE NDAO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ROTE NDAO",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5315,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANGGARAI BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANGGARAI BARAT",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5316,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBA TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBA TENGAH",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5317,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUMBA BARAT DAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUMBA BARAT DAYA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5318,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NAGEKEO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NAGEKEO",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5319,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANGGARAI TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANGGARAI TIMUR",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5320,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SABU RAIJUA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SABU RAIJUA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5321,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALAKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALAKA",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 5371,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA KUPANG",
                'type' => 'KOTA',
                'description' => "KOTA KUPANG",
                'provinsi_id' => (int)"53"
            ],
            [
                'id' => 6101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SAMBAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SAMBAS",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BENGKAYANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BENGKAYANG",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LANDAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LANDAK",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MEMPAWAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MEMPAWAH",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SANGGAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SANGGAU",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KETAPANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KETAPANG",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SINTANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SINTANG",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAPUAS HULU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAPUAS HULU",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6109,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SEKADAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SEKADAU",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6110,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MELAWI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MELAWI",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6111,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAYONG UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAYONG UTARA",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6112,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUBU RAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUBU RAYA",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PONTIANAK",
                'type' => 'KOTA',
                'description' => "KOTA PONTIANAK",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SINGKAWANG",
                'type' => 'KOTA',
                'description' => "KOTA SINGKAWANG",
                'provinsi_id' => (int)"61"
            ],
            [
                'id' => 6201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOTAWARINGIN BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOTAWARINGIN BARAT",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOTAWARINGIN TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOTAWARINGIN TIMUR",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAPUAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAPUAS",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BARITO SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BARITO SELATAN",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BARITO UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BARITO UTARA",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUKAMARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUKAMARA",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LAMANDAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LAMANDAU",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SERUYAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SERUYAN",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6209,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KATINGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KATINGAN",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6210,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PULANG PISAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PULANG PISAU",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6211,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GUNUNG MAS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GUNUNG MAS",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6212,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BARITO TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BARITO TIMUR",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6213,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MURUNG RAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MURUNG RAYA",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PALANGKA RAYA",
                'type' => 'KOTA',
                'description' => "KOTA PALANGKA RAYA",
                'provinsi_id' => (int)"62"
            ],
            [
                'id' => 6301,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANAH LAUT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANAH LAUT",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6302,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOTA BARU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOTA BARU",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6303,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANJAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANJAR",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6304,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BARITO KUALA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BARITO KUALA",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6305,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAPIN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAPIN",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6306,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HULU SUNGAI SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HULU SUNGAI SELATAN",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6307,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HULU SUNGAI TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HULU SUNGAI TENGAH",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6308,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HULU SUNGAI UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HULU SUNGAI UTARA",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6309,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TABALONG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TABALONG",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6310,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANAH BUMBU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANAH BUMBU",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6311,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BALANGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BALANGAN",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6371,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANJARMASIN",
                'type' => 'KOTA',
                'description' => "KOTA BANJARMASIN",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6372,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BANJAR BARU",
                'type' => 'KOTA',
                'description' => "KOTA BANJAR BARU",
                'provinsi_id' => (int)"63"
            ],
            [
                'id' => 6401,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PASER",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PASER",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6402,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUTAI BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUTAI BARAT",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6403,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUTAI KARTANEGARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUTAI KARTANEGARA",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6404,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KUTAI TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KUTAI TIMUR",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6405,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BERAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BERAU",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6409,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PENAJAM PASER UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PENAJAM PASER UTARA",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6411,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAHAKAM HULU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAHAKAM HULU",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6471,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BALIKPAPAN",
                'type' => 'KOTA',
                'description' => "KOTA BALIKPAPAN",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6472,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SAMARINDA",
                'type' => 'KOTA',
                'description' => "KOTA SAMARINDA",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6474,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BONTANG",
                'type' => 'KOTA',
                'description' => "KOTA BONTANG",
                'provinsi_id' => (int)"64"
            ],
            [
                'id' => 6501,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALINAU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALINAU",
                'provinsi_id' => (int)"65"
            ],
            [
                'id' => 6502,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BULUNGAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BULUNGAN",
                'provinsi_id' => (int)"65"
            ],
            [
                'id' => 6503,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANA TIDUNG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANA TIDUNG",
                'provinsi_id' => (int)"65"
            ],
            [
                'id' => 6504,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NUNUKAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NUNUKAN",
                'provinsi_id' => (int)"65"
            ],
            [
                'id' => 6571,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TARAKAN",
                'type' => 'KOTA',
                'description' => "KOTA TARAKAN",
                'provinsi_id' => (int)"65"
            ],
            [
                'id' => 7101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOLAANG MONGONDOW",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOLAANG MONGONDOW",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MINAHASA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MINAHASA",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN SANGIHE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN SANGIHE",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN TALAUD",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN TALAUD",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MINAHASA SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MINAHASA SELATAN",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MINAHASA UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MINAHASA UTARA",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOLAANG MONGONDOW UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOLAANG MONGONDOW UTARA",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIAU TAGULANDANG BIARO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIAU TAGULANDANG BIARO",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7109,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MINAHASA TENGGARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MINAHASA TENGGARA",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7110,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOLAANG MONGONDOW SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOLAANG MONGONDOW SELATAN",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7111,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOLAANG MONGONDOW TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOLAANG MONGONDOW TIMUR",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MANADO",
                'type' => 'KOTA',
                'description' => "KOTA MANADO",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BITUNG",
                'type' => 'KOTA',
                'description' => "KOTA BITUNG",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7173,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TOMOHON",
                'type' => 'KOTA',
                'description' => "KOTA TOMOHON",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7174,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA KOTAMOBAGU",
                'type' => 'KOTA',
                'description' => "KOTA KOTAMOBAGU",
                'provinsi_id' => (int)"71"
            ],
            [
                'id' => 7201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGGAI KEPULAUAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGGAI KEPULAUAN",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGGAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGGAI",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MOROWALI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MOROWALI",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN POSO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN POSO",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DONGGALA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DONGGALA",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TOLI-TOLI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TOLI-TOLI",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUOL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUOL",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PARIGI MOUTONG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PARIGI MOUTONG",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7209,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TOJO UNA-UNA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TOJO UNA-UNA",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7210,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIGI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIGI",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7211,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANGGAI LAUT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANGGAI LAUT",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7212,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MOROWALI UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MOROWALI UTARA",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PALU",
                'type' => 'KOTA',
                'description' => "KOTA PALU",
                'provinsi_id' => (int)"72"
            ],
            [
                'id' => 7301,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN SELAYAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN SELAYAR",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7302,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BULUKUMBA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BULUKUMBA",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7303,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BANTAENG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BANTAENG",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7304,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JENEPONTO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JENEPONTO",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7305,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAKALAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAKALAR",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7306,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GOWA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GOWA",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7307,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SINJAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SINJAI",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7308,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAROS",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAROS",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7309,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PANGKAJENE DAN KEPULAUAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PANGKAJENE DAN KEPULAUAN",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7310,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BARRU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BARRU",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7311,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BONE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BONE",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7312,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SOPPENG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SOPPENG",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7313,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WAJO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WAJO",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7314,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SIDENRENG RAPPANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SIDENRENG RAPPANG",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7315,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PINRANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PINRANG",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7316,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ENREKANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ENREKANG",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7317,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LUWU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LUWU",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7318,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TANA TORAJA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TANA TORAJA",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7322,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LUWU UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LUWU UTARA",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7325,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LUWU TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LUWU TIMUR",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7326,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TORAJA UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TORAJA UTARA",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7371,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA MAKASSAR",
                'type' => 'KOTA',
                'description' => "KOTA MAKASSAR",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7372,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PAREPARE",
                'type' => 'KOTA',
                'description' => "KOTA PAREPARE",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7373,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA PALOPO",
                'type' => 'KOTA',
                'description' => "KOTA PALOPO",
                'provinsi_id' => (int)"73"
            ],
            [
                'id' => 7401,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUTON",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUTON",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7402,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUNA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUNA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7403,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KONAWE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KONAWE",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7404,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOLAKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOLAKA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7405,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KONAWE SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KONAWE SELATAN",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7406,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOMBANA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOMBANA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7407,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WAKATOBI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WAKATOBI",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7408,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOLAKA UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOLAKA UTARA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7409,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUTON UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUTON UTARA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7410,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KONAWE UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KONAWE UTARA",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7411,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KOLAKA TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KOLAKA TIMUR",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7412,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KONAWE KEPULAUAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KONAWE KEPULAUAN",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7413,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MUNA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MUNA BARAT",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7414,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUTON TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUTON TENGAH",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7415,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BUTON SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BUTON SELATAN",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7471,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA KENDARI",
                'type' => 'KOTA',
                'description' => "KOTA KENDARI",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7472,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA BAUBAU",
                'type' => 'KOTA',
                'description' => "KOTA BAUBAU",
                'provinsi_id' => (int)"74"
            ],
            [
                'id' => 7501,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOALEMO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOALEMO",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7502,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GORONTALO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GORONTALO",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7503,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN POHUWATO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN POHUWATO",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7504,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BONE BOLANGO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BONE BOLANGO",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7505,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN GORONTALO UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN GORONTALO UTARA",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7571,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA GORONTALO",
                'type' => 'KOTA',
                'description' => "KOTA GORONTALO",
                'provinsi_id' => (int)"75"
            ],
            [
                'id' => 7601,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAJENE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAJENE",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 7602,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN POLEWALI MANDAR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN POLEWALI MANDAR",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 7603,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMASA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMASA",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 7604,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMUJU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMUJU",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 7605,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMUJU UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMUJU UTARA",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 7606,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMUJU TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMUJU TENGAH",
                'provinsi_id' => (int)"76"
            ],
            [
                'id' => 8101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALUKU TENGGARA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALUKU TENGGARA BARAT",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALUKU TENGGARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALUKU TENGGARA",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALUKU TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALUKU TENGAH",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BURU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BURU",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN ARU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN ARU",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SERAM BAGIAN BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SERAM BAGIAN BARAT",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SERAM BAGIAN TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SERAM BAGIAN TIMUR",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MALUKU BARAT DAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MALUKU BARAT DAYA",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8109,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BURU SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BURU SELATAN",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA AMBON",
                'type' => 'KOTA',
                'description' => "KOTA AMBON",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8172,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TUAL",
                'type' => 'KOTA',
                'description' => "KOTA TUAL",
                'provinsi_id' => (int)"81"
            ],
            [
                'id' => 8201,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HALMAHERA BARAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HALMAHERA BARAT",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8202,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HALMAHERA TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HALMAHERA TENGAH",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8203,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN SULA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN SULA",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8204,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HALMAHERA SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HALMAHERA SELATAN",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8205,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HALMAHERA UTARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HALMAHERA UTARA",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8206,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN HALMAHERA TIMUR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN HALMAHERA TIMUR",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8207,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PULAU MOROTAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PULAU MOROTAI",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8208,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PULAU TALIABU",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PULAU TALIABU",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8271,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TERNATE",
                'type' => 'KOTA',
                'description' => "KOTA TERNATE",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 8272,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA TIDORE KEPULAUAN",
                'type' => 'KOTA',
                'description' => "KOTA TIDORE KEPULAUAN",
                'provinsi_id' => (int)"82"
            ],
            [
                'id' => 9101,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN FAKFAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN FAKFAK",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9102,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KAIMANA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KAIMANA",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9103,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TELUK WONDAMA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TELUK WONDAMA",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9104,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TELUK BINTUNI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TELUK BINTUNI",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9105,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANOKWARI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANOKWARI",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9106,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SORONG SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SORONG SELATAN",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9107,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SORONG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SORONG",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9108,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN RAJA AMPAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN RAJA AMPAT",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9109,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TAMBRAUW",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TAMBRAUW",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9110,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAYBRAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAYBRAT",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9111,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MANOKWARI SELATAN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MANOKWARI SELATAN",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9112,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PEGUNUNGAN ARFAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PEGUNUNGAN ARFAK",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9171,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA SORONG",
                'type' => 'KOTA',
                'description' => "KOTA SORONG",
                'provinsi_id' => (int)"91"
            ],
            [
                'id' => 9401,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MERAUKE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MERAUKE",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9402,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JAYAWIJAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JAYAWIJAYA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9403,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN JAYAPURA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN JAYAPURA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9404,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NABIRE",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NABIRE",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9408,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEPULAUAN YAPEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEPULAUAN YAPEN",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9409,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BIAK NUMFOR",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BIAK NUMFOR",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9410,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PANIAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PANIAI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9411,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PUNCAK JAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PUNCAK JAYA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9412,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MIMIKA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MIMIKA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9413,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN BOVEN DIGOEL",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN BOVEN DIGOEL",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9414,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAPPI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAPPI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9415,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN ASMAT",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN ASMAT",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9416,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN YAHUKIMO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN YAHUKIMO",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9417,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PEGUNUNGAN BINTANG",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PEGUNUNGAN BINTANG",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9418,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN TOLIKARA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN TOLIKARA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9419,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SARMI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SARMI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9420,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN KEEROM",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN KEEROM",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9426,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN WAROPEN",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN WAROPEN",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9427,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN SUPIORI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN SUPIORI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9428,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMBERAMO RAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMBERAMO RAYA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9429,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN NDUGA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN NDUGA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9430,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN LANNY JAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN LANNY JAYA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9431,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN MAMBERAMO TENGAH",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN MAMBERAMO TENGAH",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9432,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN YALIMO",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN YALIMO",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9433,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN PUNCAK",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN PUNCAK",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9434,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DOGIYAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DOGIYAI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9435,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN INTAN JAYA",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN INTAN JAYA",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9436,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KABUPATEN DEIYAI",
                'type' => 'KABUPATEN',
                'description' => "KABUPATEN DEIYAI",
                'provinsi_id' => (int)"94"
            ],
            [
                'id' => 9471,
                'created_at' => now(),
                'created_by' => "system",
                'name' => "KOTA JAYAPURA",
                'type' => 'KOTA',
                'description' => "KOTA JAYAPURA",
                'provinsi_id' => (int)"94"
            ]
        ]);
    }
}
