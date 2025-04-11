<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\StorageSystem\Services\StorageSystemService;
use Illuminate\Http\Request;

#[Controller("/api/v1/profile_img")]
class ProfileImageController
{
    public function __construct(
        private StorageService $storageService,
        private StorageSystemService $storageSystemService,
    ) {}

    #[Post("/upload")]
    public function uploadImgProfile(Request $request)
    {
        $userContext = user_context();
        $request->validate(["img_profile_file" => "required|string"]);
        $this->storageService->putObjectFromBase64("system", "user", $userContext->id . ".jpg", $request->img_profile_file);
    }

    #[Get("/{nip}")]
    public function getFile($nip)
    {
        try {
            return $this->storageSystemService->getFile("user", $nip . ".jpg");
        } catch (\Throwable $th) {
            return null;
        }
    }
}
