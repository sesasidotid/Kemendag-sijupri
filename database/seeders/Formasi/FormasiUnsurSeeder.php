<?php

namespace Database\Seeders\Formasi;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FormasiUnsurSeeder extends Seeder
{
    public function run(): void
    {
        $sqlFilePath = base_path('database/sql/tbl_formasi_unsur.sql');
        $sql = File::get($sqlFilePath);
        DB::unprepared($sql);
    }
}