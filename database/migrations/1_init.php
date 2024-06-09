<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        foreach (glob(__DIR__ . '/init/*.php') as $filename) {
            $migration = require_once $filename;

            $reflectionClass = new \ReflectionClass($migration);
            $class = $reflectionClass->getName();

            if (class_exists($class)) {
                $migration = new $class;
                $migration->up();
            }
        }
    }

    public function down()
    {
        $files = glob(__DIR__ . '/init/*.php');
        rsort($files);

        foreach ($files as $filename) {
            $migration = require_once $filename;

            $reflectionClass = new \ReflectionClass($migration);
            $class = $reflectionClass->getName();

            if (class_exists($class)) {
                $migration = new $class;
                $migration->down();
            }
        }
    }
};
