<?php

namespace Database\Seeders\Security;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $sqlFilePath = base_path('database/sql/security/menu.sql');
        $sql = File::get($sqlFilePath);
        DB::unprepared($sql);
    }
}
