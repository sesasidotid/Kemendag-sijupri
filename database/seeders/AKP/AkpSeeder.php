<?php

namespace Database\Seeders\AKP;

use Illuminate\Database\Seeder;

class AkpSeeder extends Seeder
{
    public function run()
    {
        $this->call(AkpInstrumentSeeder::class);
        $this->call(AkpKategoriPertanyaanSeeder::class);
        $this->call(AkpPertanyaanSeeder::class);
        $this->call(AkpPelatihanSeeder::class);
        $this->call(AkpKompetensiSeeder::class);
        $this->call(AkpKompetensiPelatihanSeeder::class);
    }
}
