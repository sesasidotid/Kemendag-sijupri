<?php

namespace Eyegil\SijupriMaintenance\Services;

use Eyegil\SijupriMaintenance\Models\Pangkat;
use Eyegil\SijupriMaintenance\Models\PangkatJenjang;

class PangkatService
{
    public function findAll()
    {
        return Pangkat::where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findById($id)
    {
        return Pangkat::findOrThrowNotFound($id);
    }

    public function findByJenjangCode($jenjang_code)
    {
        return PangkatJenjang::with("pangkat")->where("jenjang_code", $jenjang_code)->get()->map(function (PangkatJenjang $pangkatJenjang) {
            return $pangkatJenjang->pangkat;
        });
    }
}
