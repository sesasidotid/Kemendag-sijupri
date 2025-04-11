<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\JabatanJenjang;
use Eyegil\SijupriMaintenance\Models\Jenjang;

class JenjangService
{
    public function findAll()
    {
        return Jenjang::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findByJabatanCode($jabatan_code)
    {
        return JabatanJenjang::where('jabatan_code', $jabatan_code)->get()->map(function (JabatanJenjang $jabatanJenjang) {
            return $jabatanJenjang->jenjang;
        });
    }

    public function findBycode($code)
    {
        return Jenjang::findOrThrowNotFound($code);
    }

    public function findNextBycode($code)
    {
        $jenjang = $this->findBycode($code);
        return Jenjang::where('idx', $jenjang->idx - 1)->firstOrThrowNotFound();
    }
}
