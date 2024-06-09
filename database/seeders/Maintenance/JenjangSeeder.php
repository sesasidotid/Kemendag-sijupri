<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenjangSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_jenjang')->insert([
            [
                'code' => 'pemula',
                'name' => 'Pemula',
                'puncak_jenjang' => 15,
                'urutan' => 1,
                'created_by' => "system",
                'type' => 'keterampilan',
                'description' => 'keterampilan pemula'
            ],
            [
                'code' => 'terampil',
                'name' => 'Terampil',
                'puncak_jenjang' => 60,
                'urutan' => 2,
                'created_by' => "system",
                'type' => 'keterampilan',
                'description' => 'keterampilan terampil'
            ],
            [
                'code' => 'mahir',
                'name' => 'Mahir',
                'puncak_jenjang' => 100,
                'urutan' => 3,
                'created_by' => "system",
                'type' => 'keterampilan',
                'description' => 'keterampilan mahir'
            ],
            [
                'code' => 'penyelia',
                'name' => 'Penyelia',
                'puncak_jenjang' => null,
                'urutan' => 4,
                'created_by' => "system",
                'type' => 'keterampilan',
                'description' => 'keterampilan penyelia'
            ],
            [
                'code' => 'pertama',
                'name' => 'Ahli Pertama',
                'puncak_jenjang' => 100,
                'urutan' => 5,
                'created_by' => "system",
                'type' => 'keahlian',
                'description' => 'keahlian pertama'
            ],
            [
                'code' => 'muda',
                'name' => 'Ahli Muda',
                'puncak_jenjang' => 200,
                'urutan' => 6,
                'created_by' => "system",
                'type' => 'keahlian',
                'description' => 'keahlian muda'
            ],
            [
                'code' => 'madya',
                'name' => 'Ahli Madya',
                'puncak_jenjang' => 450,
                'urutan' => 7,
                'created_by' => "system",
                'type' => 'keahlian',
                'description' => 'keahlian madya'
            ],
            [
                'code' => 'utama',
                'name' => 'Ahli Utama',
                'puncak_jenjang' => null,
                'urutan' => 8,
                'created_by' => "system",
                'type' => 'keahlian',
                'description' => 'keahlian utama'
            ]
        ]);
    }
}
