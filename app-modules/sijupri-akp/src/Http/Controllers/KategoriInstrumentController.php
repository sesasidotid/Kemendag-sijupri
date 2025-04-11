<?php

namespace Eyegil\SijupriAkp\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Delete;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\Base\Commons\Rest\Put;
use Eyegil\Base\Pageable;
use Eyegil\SijupriAkp\Converters\KategoriInstrumentConverter;
use Eyegil\SijupriAkp\Dtos\KategoriInstrumentDto;
use Eyegil\SijupriAkp\Services\KategoriInstrumentService;
use Illuminate\Http\Request;

#[Controller("/api/v1/kategori_instrument")]
class KategoriInstrumentController
{
    public function __construct(
        private KategoriInstrumentService $kategoriInstrumentService
    ) {}

    #[Get("/search")]
    public function findSearch(Request $request)
    {
        $query = $request->query();
        $query['eq_delete_flag'] = "false";
        return $this->kategoriInstrumentService->findSearch(new Pageable($query));
    }

    #[Get()]
    public function findAll()
    {
        return $this->kategoriInstrumentService->findAll();
    }

    #[Get("/{id}")]
    public function findById($id)
    {
        return KategoriInstrumentConverter::toDto($this->kategoriInstrumentService->findById($id));
    }

    #[Post()]
    public function save(Request $request)
    {
        $kategoriInstrumentDto = KategoriInstrumentDto::fromRequest($request)->validateSave();
        return $this->kategoriInstrumentService->save($kategoriInstrumentDto);
    }

    #[Put()]
    public function update(Request $request)
    {
        $kategoriInstrumentDto = KategoriInstrumentDto::fromRequest($request)->validateUpdate();
        return $this->kategoriInstrumentService->update($kategoriInstrumentDto);
    }

    #[Delete("/{id}")]
    public function delete($id)
    {
        return $this->kategoriInstrumentService->delete($id);
    }
}
