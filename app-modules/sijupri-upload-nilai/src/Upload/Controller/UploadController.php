<?php

namespace Src\Upload\Controller;

use Src\Upload\Request\UploadRequest;
use Src\Upload\Service\UploadService;
use Illuminate\Routing\Controller;

class UploadController extends Controller
{
    protected $service;

    public function __construct(UploadService $service)
    {
        $this->service = $service;
    }

    public function upload(UploadRequest $request)
    {
        $path = $this->service->handle($request->base64_file);

        return response()->json([
            'message' => 'File uploaded successfully.',
            'path' => $path,
        ]);
    }
}
