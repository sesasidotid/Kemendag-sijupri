<?php

namespace Eyegil\SijupriSiap\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
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
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        unset($query['eq_instansi_id']);
        unset($query['eq_provinsi_id']);
        unset($query['eq_kabupaten_id']);
        unset($query['eq_kota_id']);
        return $this->jFService->findSearch(new Pageable($query), $request->query());
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
    public function update(Request $request)
    {
        $jfDto = JFDto::fromRequest($request)->validateUpdate();
        return $this->jFService->update($jfDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->jFService->delete($id);
    }
}
