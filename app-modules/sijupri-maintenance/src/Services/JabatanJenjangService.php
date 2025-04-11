<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\JabatanJenjang;

class JabatanJenjangService
{
    public function findById($id)
    {
        return JabatanJenjang::findOrThrowNotFound($id);
    }

    public function findByJabatanCodeJenjangCode($jabatan_code, $jenjang_code)
    {
        return JabatanJenjang::where('jabatan_code', $jabatan_code)
            ->where('jenjang_code', $jenjang_code)
            ->firstOrThrowNotFound();
    }

    public function findByJabatanCode($jabatan_code)
    {
        return JabatanJenjang::where('jabatan_code', $jabatan_code)->get();
    }

    public function findByJenjangCode($jenjang_code)
    {
        return JabatanJenjang::where('jenjang_code', $jenjang_code)->get();
    }

    public function findAll()
    {
        return JabatanJenjang::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }
}
