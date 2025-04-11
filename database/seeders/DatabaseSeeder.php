<?php

namespace Database\Seeders;

use Eyegil\Base\Commons\Migration\Seedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    private const base_path = 'database/seeders/seed/';

    public function run(): void
    {
        Seedor::seedSql([
            base_path($this::base_path . 'v1/security.sql'),
            base_path($this::base_path . 'v1/security-password.sql'),
            base_path($this::base_path . 'v1/workflow.sql'),
            base_path($this::base_path . 'v1/maintenance.sql'),
            base_path($this::base_path . 'v1/akp.sql'),
            base_path($this::base_path . 'v1/formasi.sql'),
            base_path($this::base_path . 'v1/notification.sql'),

            base_path($this::base_path . 'v2/security-v2.sql'),
            base_path($this::base_path . 'v2/add-menu.sql'),
            base_path($this::base_path . 'v2/ukm-formula.sql'),
        ])->seedSeeder([
            InstansiPKKSeeder::class
        ]);
        NotificationSeeder::run();
        ExamTypeSeeder::run();
        SysConfSeeder::run();
        NotificationTopicSeeder::run();
    }
}
