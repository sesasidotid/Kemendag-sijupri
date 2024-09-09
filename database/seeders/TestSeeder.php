<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    public function run()
    {
        // User::create([
        //     'nip' => '111111111111111111',
        //     'created_at' => now(),
        //     'created_by' => "system",
        //     'password' => Crypt::encrypt(Hash::make('111111111111111111')),
        //     'name' => "SUPER ADMIN",
        //     'role_code' => 'super_admin',
        //     'app_code' => 'PUSBIN',
        // ]);

        DB::table('tbl_user')->insert([
            [
                'nip' => '197909142010121001',
                'created_at' => now(),
                'created_by' => "system",
                'password' => Crypt::encrypt(Hash::make('197909142010121001')),
                'name' => "Amir Syarifuddin",
                'role_code' => 'super_admin',
                'app_code' => 'PUSBIN',
            ]
        ]);
    }
}
