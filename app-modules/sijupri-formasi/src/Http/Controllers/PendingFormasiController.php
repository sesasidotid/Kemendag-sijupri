<?php

namespace Eyegil\SijupriFormasi\Http\Controllers;

use Eyegil\Base\Commons\Rest\Controller;
use Eyegil\Base\Commons\Rest\Get;
use Eyegil\Base\Commons\Rest\Post;
use Eyegil\SijupriFormasi\Services\PendingFormasiService;
use Eyegil\SijupriMaintenance\Models\UnitKerja;
use Illuminate\Http\Request;

#[Controller("/api/v1/pending_formasi")]
class PendingFormasiController
{
    public function __construct(
        private PendingFormasiService $pendingFormassiService,
    ) {}

    #[Get("/{unit_kerja_id}")]
    public function findByUnitKerjaId(Request $request)
    {
        return $this->pendingFormassiService->findByUnitKerjaId($request->unit_kerja_id);
    }

    #[Get("/tree/{unit_kerja_id}/{jabatan_code}")]
    public function findUnsurTreeByUnitKerjaIdAndJabatanCode(Request $request)
    {
        return $this->pendingFormassiService->findUnsurTreeByUnitKerjaIdAndJabatanCode($request->unit_kerja_id, $request->jabatan_code);
    }

    #[Post()]
    public function save(Request $request)
    {
        $unitKerja = UnitKerja::findOrThrowNotFound($request->unit_kerja_id);
        $pengali = $unitKerja->wilayah->pengali;
        return $this->pendingFormassiService->save($request->unsur_list, $pengali, $request->unit_kerja_id, $request->jabatan_code);
    }
}
