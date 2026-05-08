<?php

namespace Database\Seeders;

use Eyegil\Base\Commons\EncriptionKey;
use Eyegil\WorkflowBase\Commons\Bpmn2;
use Eyegil\WorkflowBase\Models\ProcessInstance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestSeeder extends Seeder
{
    public static function run(): void
    {
        Log::info(Crypt::decrypt("eyJpdiI6IlQ0V2RFNHpxMENSRUhsY0gyY0xFN3c9PSIsInZhbHVlIjoidjQ2VXhvRVNZS294bllSOGJra0V6T0Zrd3I3SStPYlk4ZjRHMEJpYmtwcVNKQ1pZc3RJQ296RGhFSnNaSFdOT0Z0ckwrY0hxSzBzV3RvNGFHS1Z2c2xoZjBxWGRMU0l5NEIxZnAzeGJtZVk9IiwibWFjIjoiYTJlNWJlZjE3Mzg1ZDI5ZDFlMGVkMzU2OWFiOWU2NGZjZWEyNjVjYzVlZDM4YTAzMGIyYmZmZTA4NGNlNDZkOCIsInRhZyI6IiJ9"));
    }
}
