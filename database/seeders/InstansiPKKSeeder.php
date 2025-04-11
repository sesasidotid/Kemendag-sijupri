<?php

namespace Database\Seeders;

use Eyegil\SijupriMaintenance\Models\Instansi;
use Eyegil\SijupriMaintenance\Models\KabupatenKota;
use Eyegil\SijupriMaintenance\Models\Provinsi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstansiPKKSeeder extends Seeder
{
    public static function run(): void
    {
        DB::transaction(function () {
            $provinsiList = Provinsi::all();
            foreach ($provinsiList as $key => $provinsi) {
                Instansi::createWithUuid([
                    "instansi_type_code" => "IT3",
                    "provinsi_id" => $provinsi->id,
                    "name" => "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia Provinsi " . $provinsi->name,
                ]);
                Instansi::createWithUuid([
                    "instansi_type_code" => "IT3",
                    "provinsi_id" => $provinsi->id,
                    "name" => "Badan Kepegawaian Daerah Provinsi " . $provinsi->name,
                ]);
            }

            $kab_kotaList = KabupatenKota::all();
            foreach ($kab_kotaList as $key => $kab_kota) {
                Instansi::createWithUuid([
                    "instansi_type_code" => $kab_kota->type == "KABUPATEN" ? "IT4" : "IT5",
                    "provinsi_id" => $kab_kota->provinsi_id,
                    strtolower($kab_kota->type) . "_id" => $kab_kota->id,
                    "name" => "Badan Kepegawaian dan Pengembangan Sumber Daya Manusia " . ucwords(strtolower($kab_kota->type)) . " " . ucwords(strtolower($kab_kota->name)),
                ]);
                Instansi::createWithUuid([
                    "instansi_type_code" => $kab_kota->type == "KABUPATEN" ? "IT4" : "IT5",
                    "provinsi_id" => $kab_kota->provinsi_id,
                    strtolower($kab_kota->type) . "_id" => $kab_kota->id,
                    "name" => "Badan Kepegawaian Daerah " . ucwords(strtolower($kab_kota->type)) . " " . ucwords(strtolower($kab_kota->name)),
                ]);
            }
        });
    }
}
