<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_role')->insert([

            //Admin Sijupri
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_sijupri',
                'base' => null,
                'tipe' => 'sijupri',
                'name' => "Super Admin",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'super_admin',
                'base' => 'admin_sijupri',
                'tipe' => 'sijupri',
                'name' => "Super Admin",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_formasi',
                'base' => 'admin_sijupri',
                'tipe' => 'sijupri',
                'name' => "Admin Formasi",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_ukom',
                'base' => 'admin_sijupri',
                'tipe' => 'sijupri',
                'name' => "Admin Ukom",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_pak',
                'base' => 'admin_sijupri',
                'tipe' => 'sijupri',
                'name' => "Admin Pak",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_akp',
                'base' => 'admin_sijupri',
                'tipe' => 'sijupri',
                'name' => "Admin Akp",
                'description' => 1,
            ],

            // Admin Instansi
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'admin_instansi',
                'base' => null,
                'tipe' => 'siap',
                'name' => "Admin PusBin",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'pusbin',
                'base' => 'admin_instansi',
                'tipe' => 'siap',
                'name' => "Admin PusBin",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'unit_pembina',
                'base' => 'admin_instansi',
                'tipe' => 'siap',
                'name' => "Instansi Kementerian Lembaga",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'bkpsdm_bkd',
                'base' => 'admin_instansi',
                'tipe' => 'siap',
                'name' => "Instansi Daerah",
                'description' => 1,
            ],


            //Pengatur Siap
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'pengatur_siap',
                'base' => null,
                'tipe' => 'siap',
                'name' => "pengatur_siap",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'ses',
                'base' => 'pengatur_siap',
                'tipe' => 'siap',
                'name' => "ses",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'unit_kerja',
                'base' => 'pengatur_siap',
                'tipe' => 'siap',
                'name' => "unit kerja",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'opd',
                'base' => 'pengatur_siap',
                'tipe' => 'siap',
                'name' => "admin opd",
                'description' => 1,
            ],


            //USER
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'user',
                'base' => null,
                'tipe' => 'siap',
                'name' => "user",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'user_internal',
                'base' => 'user',
                'tipe' => 'siap',
                'name' => "user",
                'description' => 1,
            ],
            [
                'created_at' => now(),
                'created_by' => "system",
                'code' => 'user_external',
                'base' => 'user',
                'tipe' => 'siap',
                'name' => "user",
                'description' => 1,
            ],
        ]);
    }
}
