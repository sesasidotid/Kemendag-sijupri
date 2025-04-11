<?php

namespace Database\Seeders;

use Eyegil\SijupriMaintenance\Models\JabatanJenjang;
use Eyegil\SijupriUkom\Models\UkomFormula;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerateFormula extends Seeder
{
    public static function run(): void
    {
        foreach (JabatanJenjang::all() as $key => $jabatanJenjang) {
            $ukomFormula = new UkomFormula();
            $ukomFormula->jabatan_code = $jabatanJenjang->jabatan_code;
            $ukomFormula->jenjang_code = $jabatanJenjang->jenjang_code;
            $ukomFormula->saveWithUuid();
        }
    }
}
