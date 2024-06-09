<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkatSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_pangkat')->insert([
            // [
            //     'name' => "Ia",
            //     'description' => "Juru Muda"
            // ],
            // [
            //     'name' => "Ib",
            //     'description' => "Juru Muda Tingkat I"
            // ],
            // [
            //     'name' => "Ic",
            //     'description' => "Juru"
            // ],
            // [
            //     'name' => "Id",
            //     'description' => "Juru Tingkat I"
            // ],
            [
                'name' => "IIa",
                'description' => "Pengatur Muda"
            ],
            [
                'name' => "IIb",
                'description' => "Pengatur Muda Tingkat I"
            ],
            [
                'name' => "IIc",
                'description' => "Pengatur"
            ],
            [
                'name' => "IId",
                'description' => "Pengatur Tingkat I"
            ],
            [
                'name' => "IIIa",
                'description' => "Penata Muda"
            ],
            [
                'name' => "IIIb",
                'description' => "Penata Muda Tk. I"
            ],
            [
                'name' => "IIIc",
                'description' => "Penata"
            ],
            [
                'name' => "IIId",
                'description' => "Penata Tk. I"
            ],
            [
                'name' => "IVa",
                'description' => "Pembina"
            ],
            [
                'name' => "IVb",
                'description' => "Pembina Tk. I"
            ],
            [
                'name' => "IVc",
                'description' => "Pembina Utama Muda"
            ],
            [
                'name' => "IVd",
                'description' => "Pembina Utama Madya"
            ],
        ]);
    }
}
