<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\UkomBanDto;
use Eyegil\SijupriUkom\Services\UkomBanService;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_ban")]
class UkomBanController
{
    public function __construct(
        private UkomBanService $ukomBanService,
    ) {
    }

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        return $this->ukomBanService->findSearch(new Pageable($request->query()));
    }

    #[Get("/banme")]
    public function banMe(Request $request)
    {
        $query = $request->query();
        if (!isset($query["key"]) && empty($query["key"])) {
            throw new RecordNotFoundException();
        }
        return $this->ukomBanService->banMe($query["key"]);
    }

    #[Post()]
    public function ban(Request $request)
    {
        $ukomBanDto = UkomBanDto::fromRequest($request);
        return $this->ukomBanService->ban($ukomBanDto);
    }

    #[Put()]
    public function editBan(Request $request)
    {
        $ukomBanDto = UkomBanDto::fromRequest($request);
        return $this->ukomBanService->editBan($ukomBanDto);
    }

    #[Delete("/{id}")]
    public function unBan($id)
    {
        return $this->ukomBanService->unBan($id);
    }
}
