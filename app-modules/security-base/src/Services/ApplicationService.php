<?php

namespace Eyegil\SecurityBase\Services;

use Eyegil\SecurityBase\Models\Application;

class ApplicationService
{
    public function __construct()
    {
    }

    public function findAll()
    {
        return Application::orderBy("idx", "asc")->get();
    }

    public function findByCode(string $code): Application
    {
        return Application::findOrThrowNotFound($code);
    }
}
