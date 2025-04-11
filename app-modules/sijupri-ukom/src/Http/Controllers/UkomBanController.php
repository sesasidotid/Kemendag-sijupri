<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\SijupriUkom\Services\UkomBanService;
use Illuminate\Database\RecordNotFoundException;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_ban")]
class UkomBanController
{
    public function __construct(
        private UkomBanService $ukomBanService,
    ) {}

    #[Get("/banme")]
    public function banMe(Request $request)
    {
        $query = $request->query();
        if (!isset($query["key"]) && empty($query["key"])) {
            throw new RecordNotFoundException();
        }
        return $this->ukomBanService->banMe($query["key"]);
    }
}
