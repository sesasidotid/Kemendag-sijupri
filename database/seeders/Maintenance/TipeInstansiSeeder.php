<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeInstansiSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_tipe_instansi')->insert([
            [
                'code' => 'pusbin',
                'name' => 'pusbin',
                'description' => 'instansi pusbin',
            ],
            [
                'code' => 'kementerian_lembaga',
                'name' => 'kementerian/lembaga',
                'description' => 'instansi kementerian/lembaga',
            ],
            [
                'code' => 'provinsi',
                'name' => 'provinsi',
                'description' => 'instansi provinsi',
            ],
            [
                'code' => 'kabupaten',
                'name' => 'kabupaten',
                'description' => 'instansi kabupaten',
            ],
            [
                'code' => 'kota',
                'name' => 'kota',
                'description' => 'instansi kota',
            ],
        ]);
    }
}
