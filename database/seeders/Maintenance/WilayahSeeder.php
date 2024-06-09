<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_wilayah')->insert([
            ["code" => 'jawa', "region" => "Jawa", "pengali" => 1],
            ["code" => 'balis', "region" => "Bali", "pengali" => 1],
            ["code" => 'sumatera', "region" => "Sumatera", "pengali" => 1.1],
            ["code" => 'kalimantan', "region" => "Kalimantan", "pengali" => 1.1],
            ["code" => 'sulawesi', "region" => "Sulawesi", "pengali" => 1.1],
            ["code" => 'papua', "region" => "Papua", "pengali" => 1.4],
            ["code" => 'kepulauan', "region" => "Kepulauan", "pengali" => 1.4],
            ["code" => 'daerah_perbatasan', "region" => "Daerah Perbatasan", "pengali" => 1.4],
            ["code" => 'pulau_terluar', "region" => "Pulau Terluar", "pengali" => 1.5],
        ]);
    }
}
