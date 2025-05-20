<?php
namespace Src\Upload;

use Illuminate\Support\ServiceProvider;
use Src\Upload\Service\UploadService;

class UploadServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UploadService::class, function () {
            return new UploadService();
        });
    }
}


