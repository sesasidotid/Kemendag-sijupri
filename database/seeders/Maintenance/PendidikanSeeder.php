<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_pendidikan')->insert([
            [
                'created_by' => "system",
                'name' => "SMP",
                'description' => "Pengatur Muda"
            ],
            [
                'created_by' => "system",
                'name' => "SMA",
                'description' => "Pengatur Muda"
            ],
            [
                'created_by' => "system",
                'name' => "D3",
                'description' => "Pengatur Muda"
            ],
            [
                'created_by' => "system",
                'name' => "D4/S1",
                'description' => "Pengatur Muda"
            ],
        ]);
    }
}
