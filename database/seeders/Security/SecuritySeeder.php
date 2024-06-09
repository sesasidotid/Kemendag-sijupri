<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(RoleMenuSeeder::class);
    }
}
