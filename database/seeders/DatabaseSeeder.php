<?php

namespace Database\Seeders;

use Database\Seeders\AKP\AkpSeeder;
use Database\Seeders\Formasi\FormasiSeeder;
use Database\Seeders\Maintenance\MaintenanceSeeder;
use Database\Seeders\Security\SecuritySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    protected $sourceDirectory = '/sesasi/app/sijupri-sql';
    protected $successDirectory = '/sesasi/app/sijupri-success-sql';


    public function run()
    {
        $this->call(MaintenanceSeeder::class);
        $this->call(AkpSeeder::class);
        $this->call(FormasiSeeder::class);
        $this->call(SecuritySeeder::class);

        // if (!File::exists($this->successDirectory)) {
        //     File::makeDirectory($this->successDirectory, 0755, true);
        // }

        // // Loop through SQL files in the source directory
        // $files = File::files($this->sourceDirectory);

        // foreach ($files as $file) {
        //     $filePath = $file->getPathname();

        //     // Read the contents of the SQL file
        //     $sql = File::get($filePath);

        //     // Check if the SQL content is empty
        //     if (trim($sql) === '') {
        //         Log::warning("Skipped empty file: " . $file->getFilename());
        //         continue; // Skip to the next file
        //     }

        //     // Split the SQL queries by ';', trim them, and filter out empty queries
        //     $queries = array_filter(array_map('trim', explode(';', $sql)));

        //     // Attempt to execute each query within a transaction
        //     try {
        //         DB::transaction(function () use ($queries, $filePath, $file) {
        //             foreach ($queries as $query) {
        //                 // Execute the SQL query
        //                 if (!empty($query)) { // Double-check to ensure the query is not empty
        //                     DB::unprepared($query);
        //                 }
        //             }

        //             // If successful, move the file to the success directory
        //             File::move($filePath, $this->successDirectory . '/' . $file->getFilename());
        //             Log::info("Successfully executed: " . $file->getFilename());
        //         });
        //     } catch (\Exception $e) {
        //         // Log the error and skip the file
        //         Log::error("Failed to execute: " . $file->getFilename() . " | Error: " . $e->getMessage());
        //     }
        // }
    }
}
