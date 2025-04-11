<?php

namespace Eyegil\SijupriUkom\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriUkom\Dtos\UkomFormulaDto;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Eyegil\SijupriUkom\Services\UkomFormulaService;
use Illuminate\Http\Request;

#[Controller("/api/v1/ukom_formula")]
class UkomFormulaController
{
    public function __construct(
        private UkomFormulaService $ukomFormulaService,
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $search =  $this->ukomFormulaService->findSearch(new Pageable($request->query()));
        return $search->setCollection($search->getCollection()->map(function (UkomFormula $ukomFormula) {
            $ukomFormulaDto = (new UkomFormulaDto())->fromModel($ukomFormula);
            $ukomFormulaDto->jabatan_name = $ukomFormula->jabatan->name;
            $ukomFormulaDto->jenjang_name = $ukomFormula->jenjang->name;

            return $ukomFormulaDto;
        }));
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return $this->ukomFormulaService->findById($id);
    }

    #[Put()]
    public function update(Request $request)
    {
        $ukomFormulaDto = UkomFormulaDto::fromRequest($request)->validateUpdate();
        return $this->ukomFormulaService->update($ukomFormulaDto);
    }
}
