<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        foreach (glob(__DIR__ . '/alter/*.php') as $filename) {
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
        $files = glob(__DIR__ . '/alter/*.php');
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
