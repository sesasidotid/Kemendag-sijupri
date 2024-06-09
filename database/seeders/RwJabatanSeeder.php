<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JenjangPangkat;
use App\Models\UserDetail;
class RwJabatanSeeder extends Seeder
{

    public function run()
    {
        $users = UserDetail::orderBy('id')->get();

        foreach ($users as $index => $user) {
            $jenjang = JenjangPangkat::with('poinKoefisienPerformances')->find($user->jenjang_id);

            if ($jenjang) {
                $data = [
                    'tipe_jabatan' => 'Tipe Jabatan 1',
                    'tmt' => now(),
                    'jabatan' => 'Jabatan 1',
                    'sk_jabatan' => 'SK Jabatan 1',
                    'sk_pangkat' => 'SK Pangkat 1',
                    'nip' => $user->nip,
                    'jabatan_id' => $user->jabatan_id,
                    'pangkat_id' => $user->pangkat_id,
                ];
                DB::table('tbl_rw_jabatan')->insert($data);
            }
        }
    }
}
