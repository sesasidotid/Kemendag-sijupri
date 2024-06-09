<?php

namespace Database\Seeders;

use Database\Seeders\AKP\AkpSeeder;
use Database\Seeders\Formasi\FormasiSeeder;
use Database\Seeders\Maintenance\MaintenanceSeeder;
use Database\Seeders\Security\SecuritySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(MaintenanceSeeder::class);
        $this->call(AkpSeeder::class);
        $this->call(FormasiSeeder::class);
        $this->call(SecuritySeeder::class);
    }
}
