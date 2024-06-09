<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_modul')->insert([
            [
                'code' => 'siap',
                'created_by' => "system",
                'name' => 'sijupri',
            ],
            [
                'code' => 'formasi',
                'created_by' => "system",
                'name' => 'formasi',
            ],
            [
                'code' => 'akp',
                'created_by' => "system",
                'name' => 'akp',
            ],
            [
                'code' => 'pak',
                'created_by' => "system",
                'name' => 'pak',
            ],
            [
                'code' => 'ukom',
                'created_by' => "system",
                'name' => 'ukom',
            ],
            [
                'code' => 'user',
                'created_by' => "system",
                'name' => 'user',
            ]
        ]);
    }
}
