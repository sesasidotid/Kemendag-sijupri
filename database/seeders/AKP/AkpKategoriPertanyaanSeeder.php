<?php

namespace Database\Seeders\AKP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AkpKategoriPertanyaanSeeder extends Seeder
{
    public function run(): void
    {
        $sqlFilePath = base_path('database/sql/tbl_akp_kategori_pertanyaan.sql');
        $sql = File::get($sqlFilePath);
        DB::unprepared($sql);
    }
}