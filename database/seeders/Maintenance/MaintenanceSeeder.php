<?php

namespace Database\Seeders\Maintenance;

use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $this->call(ModulSeeder::class);
        // $this->call(DokumenPersyaratanSeeder::class);
        $this->call(PangkatSeeder::class);
        $this->call(JabatanSeeder::class);
        $this->call(JenjangSeeder::class);
        $this->call(ProvinsiSeeder::class);
        $this->call(TipeInstansiSeeder::class);
        $this->call(InstansiSeeder::class);
        $this->call(WilayahSeeder::class);
        $this->call(SystemConfiturationSeeder::class);
        
        $this->call(KabKotaSeeder::class);

        $this->call(UnitKerjaSeeder::class);
    }
}
