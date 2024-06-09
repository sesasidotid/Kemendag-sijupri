<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Security\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{

    public function searchUser(Request $request)
    {
        $user = new UserService();
        $length = null;
        $page = null;

        $data = $this->getData($request, $page, $length);
        Log::info("AAAAAAAAAAAAAAA " . $page);

        $result = $user->findSearchPaginate($data, $page, $length);

        $no = 1;
        $mappedResult = array_map(function ($item) use (&$no) {
            $map = (object) $item;
            $map->no = $no++;
            $map->role_code = $item->role->code ?? null;
            $map->role_name = $item->role->name ?? null;
            $map->pangkat_code = $item->pangkat->pangkat->code ?? null;
            $map->pangkat_name = $item->pangkat->pangkat->name ?? null;
            $map->jabatan_code = $item->jabatan->jabatan->code ?? null;
            $map->jabatan_name = $item->jabatan->jabatan->name ?? null;
            $map->jenjang_name = $item->jabatan->jenjang->name ?? null;
            $map->jenjang_code = $item->jabatan->jenjang->code ?? null;
            $map->unit_kerja_id = $item->unitKerja->id ?? null;
            $map->unit_kerja_name = $item->unitKerja->name ?? null;
            $map->provinsi_id = $item->unitKerja->instansi->provinsi->id ?? null;
            $map->provinsi_name = $item->unitKerja->instansi->provinsi->name ?? null;
            $map->kabupaten_id = $item->unitKerja->instansi->kabupaten->id ?? null;
            $map->kabupaten_name = $item->unitKerja->instansi->kabupaten->name ?? null;
            $map->kota_id = $item->unitKerja->instansi->kota->id ?? null;
            $map->kota_name = $item->unitKerja->instansi->kota->name ?? null;

            return $map;
        }, $result->items());
        return response()->json($this->getResponse($request, $result, $mappedResult));
    }

    private function getData($request, &$page, &$length)
    {
        $length = $request->input('length', 10);
        $page = ($length + $request->input('start', 0)) / $length;
        // foreach ($request->input('columns', []) as $key => $value) {
        //     $data[$value->data] = $value;
        // }

        return [];
    }

    private function getResponse($request, $result, $mappedResult)
    {
        return [
            'draw' => $request->input('draw', 1),
            'recordsTotal' => $result->total(),
            'recordsFiltered' => $result->total(),
            'pageLength' => $result->lastPage(),
            'currentPage' => $result->currentPage(),
            'data' => $mappedResult,
        ];
    }
}
