<?php

namespace Database\Seeders\AKP;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkpKompetensiPelatihanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tbl_akp_kompetensi_pelatihan')->insert([
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 1,
                'akp_pelatihan_id' => 1
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 1,
                'akp_pelatihan_id' => 2
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 2,
                'akp_pelatihan_id' => 3
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 4,
                'akp_pelatihan_id' => 12
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 10,
                'akp_pelatihan_id' => 5
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 10,
                'akp_pelatihan_id' => 5
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 11,
                'akp_pelatihan_id' => 5
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 12,
                'akp_pelatihan_id' => 5
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 13,
                'akp_pelatihan_id' => 7
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 14,
                'akp_pelatihan_id' => 7
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 15,
                'akp_pelatihan_id' => 6
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 15,
                'akp_pelatihan_id' => 6
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 16,
                'akp_pelatihan_id' => 6
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 17,
                'akp_pelatihan_id' => 6
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 20,
                'akp_pelatihan_id' => 3
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 25,
                'akp_pelatihan_id' => 3
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 26,
                'akp_pelatihan_id' => 3
            ],
            [
                'created_at' => now(),
                'created_by' => 'system',
                'akp_kompetensi_id' => 26,
                'akp_pelatihan_id' => 3
            ],
        ]);
    }
}
