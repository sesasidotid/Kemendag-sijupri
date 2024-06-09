<?php

namespace Database\Seeders;

use App\Models\JenjangPangkat;
use App\Models\PangkatGolongan;
use App\Models\PoinKoefisienPerformance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoinKoefisienPerformanceSeeder extends Seeder
{
    public function run()
    {
        $this->jenjangPangkat();
        $this->pangkatGolongan();
        $this->koefisien();
    }
    public function koefisien()
    {
        $data = [
            ['jenjang_id' => 1, 'pangkat_id' => 1, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 15],
            ['jenjang_id' => 2, 'pangkat_id' => 2, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 20],
            ['jenjang_id' => 2, 'pangkat_id' => 3, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 40],
            ['jenjang_id' => 2, 'pangkat_id' => 4, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 60],
            ['jenjang_id' => 3, 'pangkat_id' => 5, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 50],
            ['jenjang_id' => 3, 'pangkat_id' => 6, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 100],
            ['jenjang_id' => 4, 'pangkat_id' => 7, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 100],
            ['jenjang_id' => 4, 'pangkat_id' => 8, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => null],//null
            ['jenjang_id' => 5, 'pangkat_id' => 9, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 50],
            ['jenjang_id' => 5, 'pangkat_id' => 10, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 100],
            ['jenjang_id' => 6, 'pangkat_id' => 11, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 100],
            ['jenjang_id' => 6, 'pangkat_id' => 12, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 200],
            ['jenjang_id' => 7, 'pangkat_id' => 13, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 150],
            ['jenjang_id' => 7, 'pangkat_id' => 14, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 300],
            ['jenjang_id' => 7, 'pangkat_id' => 15, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 450],
            ['jenjang_id' => 8, 'pangkat_id' => 16, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 200],
            ['jenjang_id' => 8, 'pangkat_id' => 17, 'kategori' => 'KEAHLIAN', 'max_standar_point' => null],//null
        ];




        // Using the LevelClass model to insert data
        foreach ($data as $entry) {
            PoinKoefisienPerformance::create($entry);
        }
    }
    public function jenjangPangkat()
    {
        $data = [
            ['jenjang' => 'Pemula','puncak_jenjang'=> 15],//jenjang_id: 1
            ['jenjang' => 'Terampil','puncak_jenjang'=> 60],//2
            ['jenjang' => 'Mahir','puncak_jenjang'=> 100],//3
            ['jenjang' => 'Penyelia','puncak_jenjang'=> null],//4
            ['jenjang' => 'Ahli Pertama','puncak_jenjang'=> 100],//5
            ['jenjang' => 'Ahli Muda','puncak_jenjang'=> 200],//6
            ['jenjang' => 'Ahli Madya','puncak_jenjang'=> 450],//7
            ['jenjang' => 'Ahli Utama','puncak_jenjang'=> null],//8
        ];
        foreach ($data as $entry) {
            JenjangPangkat::create($entry);
        }
    }
    public function pangkatGolongan()
    {
        $data = [
            ['pangkat' => 'II/a'],//pangkat_id: 1
            ['pangkat' => 'II/b'],
            ['pangkat' => 'II/c'],
            ['pangkat' => 'II/d'],
            ['pangkat' => 'III/a'],
            ['pangkat' => 'III/b'],
            ['pangkat' => 'III/c'],
            ['pangkat' => 'III/d'],
            ['pangkat' => 'III/a'],
            ['pangkat' => 'III/b'],
            ['pangkat' => 'III/c'],
            ['pangkat' => 'III/d'],
            ['pangkat' => 'IV/a'],
            ['pangkat' => 'IV/b'],
            ['pangkat' => 'IV/c'],
            ['pangkat' => 'IV/d'],
            ['pangkat' => 'IV/e'],
        ];


        foreach ($data as $entry) {
            PangkatGolongan::create($entry);
        }
    }
}
