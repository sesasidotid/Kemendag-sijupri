<?php

namespace Database\Seeders\Formasi;

use Illuminate\Database\Seeder;

class FormasiSeeder extends Seeder
{
    public function run()
    {
        $this->call(FormasiUnsurSeeder::class);
    }
}
