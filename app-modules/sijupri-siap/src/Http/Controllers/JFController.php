<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriSiap\Converters\JFConverter;
use Eyegil\SijupriSiap\Dtos\JFDto;
use Eyegil\SijupriSiap\Services\JFService;
use Eyegil\StorageBase\Services\StorageService;
use Eyegil\WorkflowBase\Services\PendingTaskService;
use Illuminate\Http\Request;

#[Controller("/api/v1/jf")]
class JFController
{
    public function __construct(
        private JFService $jFService,
        private PendingTaskService $pendingTaskService,
        private StorageService $storageService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->jFService->findSearch(new Pageable($request->query()));
    }

    #[Get()]
    public function findAll()
    {
        return $this->jFService->findAll();
    }

    #[Get("/{nip}")]
    public function findByNip($nip)
    {
        $jf = $this->jFService->findByNip($nip);
        $jfDto = JFConverter::toDto($jf);
        if ($jf->ktp)
            $jfDto->ktp_url = $this->storageService->getUrl("system", "jf", $jf->ktp);

        return $jfDto;
    }

    #[Get("/expect_pending/{nip}")]
    public function findByNipExpectPending($nip)
    {
        $userContext = user_context();
        return $this->pendingTaskService->findByObjectIdAndTaskStatusPending($userContext->id);
    }

    #[Post()]
    public function save(Request $request)
    {
        $jfDto = JFDto::fromRequest($request)->validateSave();
        return $this->jFService->save($jfDto);
    }

    #[Put()]
    public function put_update(Request $request)
    {
        $jfDto = JFDto::fromRequest($request)->validateUpdate();
        return $this->jFService->update($jfDto);
    }
}
