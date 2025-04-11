<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\Jabatan;
use Eyegil\SijupriMaintenance\Models\JabatanJenjang;

class JabatanService
{
    public function findAll()
    {
        return Jabatan::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findByJenjangCode($jenjang_code)
    {
        return JabatanJenjang::where("jenjang_code", $jenjang_code)->get()->map(function (JabatanJenjang $jabatanJenjang) {
            return $jabatanJenjang->jabatan;
        });
    }

    public function findByCode($code)
    {
        return Jabatan::findOrThrowNotFound($code);
    }
}
