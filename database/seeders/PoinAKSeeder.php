<?php

namespace Database\Seeders;

use App\Enums\RoleCode;
use App\Models\Jabatan;
use App\Models\Jenjang;
use App\Models\JenjangPangkat;
use App\Models\Pangkat;
use App\Models\PoinAK;
use App\Models\PoinAngkaKredit;
use App\Models\PoinKoefisienPerformance;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PoinAKSeeder extends Seeder
{
    public function run(): void
    {
        $this->user();
       $this->poinAK();
    }
    public function user()
    {
        $faker = Faker::create();
        $jabatan = [
            // jabatan_id => jenjang_id yang tersedia
            1 => [2, 3, 4, 5, 6, 7],
            2 => [1, 2, 3, 4],
            3 => [5, 6, 7],
            4 => [5, 6, 7],
            5 => [1, 2, 3, 4, 5, 6, 7],
            6 => [5, 6, 7, 8],
            7 => [5, 6, 7, 8],
            8 => [5, 6, 7],
            9 => [5, 6, 7, 8],
            10 => [5, 6, 7, 8],
            11 => [5, 6, 7, 8],
        ];
        // Define jenjang and pangkat data
        $jenjangPangkatData = [
            // jenjang_id => array dari pangkat_id
            1 => [1],
            2 => [2, 3, 4],
            3 => [5, 6],
            4 => [7, 8],
            5 => [9, 10],
            6 => [11, 12],
            7 => [13, 14, 15],
            8 => [16, 17],
        ];
        $counter = 2;

        foreach ($jabatan as $jabatanId => $jenjangIds) {
            foreach ($jenjangIds as $jenjangId) {
                // Cek apakah jenjang_id ada di dalam jenjangPangkatData
                if (array_key_exists($jenjangId, $jenjangPangkatData)) {
                    $nip = $faker->numerify('##################');

                    DB::table('tbl_user')->insert([
                        'nip' => $nip,
                        'created_at' => now(),
                        'created_by' => 'Seeder',
                        'password' => Hash::make('password123'),
                        'name' => $faker->name,
                        'tipe_instansi_code' => null,
                        'user_status' => 'ACTIVE',
                        'delete_flag' => false,
                        'unit_kerja_id' => null,
                        'role_code' => RoleCode::USER,
                    ]);

                    $randomPangkat = $jenjangPangkatData[$jenjangId][array_rand($jenjangPangkatData[$jenjangId])];

                    DB::table('tbl_user_detail')->insert([
                        'jenis_kelamin' => $faker->randomElement(['Pria', 'Wanita']),
                        'karpeg' => null,
                        'nik' => $faker->numerify('################'),
                        'tempat_lahir' => $faker->city,
                        'tanggal_lahir' => $faker->date,
                        'email' => $faker->unique()->safeEmail,
                        'no_hp' => $faker->phoneNumber,
                        'file_ktp' => '/ktp' . $faker->numerify('################') . '_ktp.pdf',

                        'nip' => $nip,
                        'id' => $counter,
                    ]);
                    $counter++;
                }
            }
        }
    }


    public function userMaintainance()
    {
        $faker = Faker::create();
        $jabatan = [
            //jabatan_id=>jenjang_id yang tersedia
            1 => [1, 2, 3, 4, 5, 6, 7],
            2 => [1, 2, 3, 4],
            3 => [5, 6, 7],
            4 => [5, 6, 7],
            5 => [1, 2, 3, 4, 5, 6, 7],
            6 => [5, 6, 7, 8],
            7 => [5, 6, 7, 8],
            8 => [5, 6, 7],
            9 => [5, 6, 7, 8],
            10 => [5, 6, 7, 8],
            11 => [5, 6, 7, 8],
        ];
        // Define jenjang and pangkat data
        $jenjangPangkatData = [
            //jenjang_di=>pangkat_id
            1 => [1],
            2 => [2, 3, 4],
            3 => [5, 6],
            4 => [7, 8],
            5 => [9, 10],
            6 => [11, 12],
            7 => [13, 14, 15],
            8 => [16, 17],
        ];
        $counter = 1;
        foreach ($jenjangPangkatData as $jenjangId => $pangkatIds) {
            foreach ($pangkatIds as $pangkatId) {
                $nip = $faker->numerify('##################');

                DB::table('tbl_user')->insert([
                    'nip' => $nip,
                    'tanggal_dibuat' => now(),
                    'dibuat_oleh' => 'Seeder',
                    'password' => Hash::make('password123'),
                    'nama_lengkap' => $faker->name,
                    'jenis_instansi_id' => null,
                    'user_status' => 'ACTIVE',
                    'delete_flag' => false,
                    'opd_id' => null,
                    'role_id' => 1,
                ]);

                DB::table('tbl_user_detail')->insert([
                    'jenis_kelamin' => $faker->randomElement(['Pria', 'Wanita']),
                    'karpeg' => null,
                    'nik' => $faker->numerify('################'),
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date,
                    'email' => $faker->unique()->safeEmail,
                    'no_hp' => $faker->phoneNumber,

                    'jabatan_id' => 1, //jenjang harus IN jabatan
                    'jenjang_id' => $jenjangId,
                    'pangkat_id' => $pangkatId,
                    'nip' => $nip,
                    'id' => $counter
                ]);
                $counter++;
            }
        }
    }

    public function poinAK()
    {
        $faker = Faker::create();
        $users = UserDetail::orderBy('id')->get();


        $data = [
            ['jenjang_id' => 1, 'pangkat_id' => 1, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 15],
            ['jenjang_id' => 2, 'pangkat_id' => 2, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 20],
            ['jenjang_id' => 2, 'pangkat_id' => 3, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 40],
            ['jenjang_id' => 2, 'pangkat_id' => 4, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 60],
            ['jenjang_id' => 3, 'pangkat_id' => 5, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 50],
            ['jenjang_id' => 3, 'pangkat_id' => 6, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 100],
            ['jenjang_id' => 4, 'pangkat_id' => 7, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => 100],
            ['jenjang_id' => 4, 'pangkat_id' => 8, 'kategori' => 'KETERAMPILAN', 'max_standar_point' => null], //null
            ['jenjang_id' => 5, 'pangkat_id' => 9, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 50],
            ['jenjang_id' => 5, 'pangkat_id' => 10, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 100],
            ['jenjang_id' => 6, 'pangkat_id' => 11, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 100],
            ['jenjang_id' => 6, 'pangkat_id' => 12, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 200],
            ['jenjang_id' => 7, 'pangkat_id' => 13, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 150],
            ['jenjang_id' => 7, 'pangkat_id' => 14, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 300],
            ['jenjang_id' => 7, 'pangkat_id' => 15, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 450],
            ['jenjang_id' => 8, 'pangkat_id' => 16, 'kategori' => 'KEAHLIAN', 'max_standar_point' => 200],
            ['jenjang_id' => 8, 'pangkat_id' => 17, 'kategori' => 'KEAHLIAN', 'max_standar_point' => null], //null
        ];

        $ak_total = 0;
        $ak_terakhir = 0;
        $ak_terbaru = 0;
        foreach ($users as $index => $user) {
            $jenjang = JenjangPangkat::with('poinKoefisienPerformances')->find($user->jenjang_id);
            if ($jenjang) {

                //temp
                $ak_terakhir_temp = $ak_terakhir;
                $ak_terbaru_temp = $ak_terbaru;
                $ak_total_temp = $ak_total;


                $result = $this->findMaxPangkat($data, $user['jenjang_id'], $ak_total, $ak_terakhir);
                $ak_terakhir = mt_rand($result['min_pangkat_terakhir'], $result['max_pangkat_terakhir'] + 10);
                $ak_terbaru = $faker->randomFloat(2, 2, 30);
                $ak_total = $ak_terakhir + $ak_terbaru;

                $maxJenjangElement = null;
                $maxPangkatElement = null;

                if ($result['pangkat_id_with_max_poin'] !== null) {
                    $maxJenjangElement = collect($data)
                        ->where('jenjang_id', $user['jenjang_id'])
                        ->max('max_standar_point');

                    $maxPangkatElement = collect($data)
                        ->where('pangkat_id', $result['pangkat_id_with_max_poin'])
                        ->max('max_standar_point');

                    if (($user['jenjang_id'] === 8 && $result['pangkat_id_with_max_poin'] === 17) || ($user['jenjang_id'] === 4 && $result['pangkat_id_with_max_poin'] === 8)) {
                        $maxJenjangElement = $maxPangkatElement;
                    }
                }

                //test
                $testUKOM = $maxJenjangElement - $ak_total_temp;
                if ($ak_terbaru_temp != 0 && $ak_terbaru_temp != 0) {
                    $test_passed = ($testUKOM >= 0) ? 0 : 1;
                }

                $tanggal_mulai = '12-3-2011';
                $status_periodik = $faker->randomElement(['0', '1']);
                // Konversi tanggal_mulai menjadi objek Carbon
                $tanggal_mulai_obj = \Carbon\Carbon::createFromFormat('d-m-Y', $tanggal_mulai);

                // Tentukan kondisi untuk menentukan tanggal_selesai
                if ($status_periodik == '1') {
                    // Jika status_periodik = 1, tambahkan 1 tahun ke tanggal_mulai
                    $tanggal_selesai_obj = $tanggal_mulai_obj->addYear();
                } else {
                    // Jika status_periodik = 0, tambahkan 1 bulan ke tanggal_mulai
                    $tanggal_selesai_obj = $tanggal_mulai_obj->addMonth();
                }

                // Format tanggal_selesai dalam format yang diinginkan
                $tanggal_selesai = $tanggal_selesai_obj->format('d-m-Y');
                $selisih_jenjang= $ak_total_temp - ($maxJenjangElement ?? 0);
                DB::table('tbl_poin_angka_kredit')->insert([
                    'user_id' => $user->id,
                    'test_passed' => $test_passed ?? 0,
                    'ak_terbaru' => $ak_terbaru_temp,
                    'ak_terakhir' => $ak_terakhir_temp,
                    'ak_total' => $ak_total_temp,
                    'jabatan_id' => $user['jabatan_id'],
                    'jenjang_id' => $user['jenjang_id'],
                    'pangkat_id' => $result['pangkat_id_with_max_poin'],
                    'pangkat_id_terakhir' => $result['pangkat_id_terakhir'],
                    'max_jenjang' => $maxJenjangElement ?? 0,
                    'max_pangkat' => $maxPangkatElement ?? 0,
                    'max_standar_point' => $result['max_pangkat_terakhir'],
                    'min_pangkat_terakhir' => $result['min_pangkat_terakhir'] ?? null,
                    'selisih_pangkat' => $result['selisih_poin'],
                    'selisih_jenjang' =>$selisih_jenjang,
                    'rating' => $faker->numberBetween(1, 5),
                    'pdf_dokumen_ak_terakhir'=>'dokumen_ak_terakhir_ '. ($index + 1) . '.pdf',
                    'pdf_akumulasi_ak_konversi'=>'akumulasi_ak_konversi_' . ($index + 1) . '.pdf',
                    'pdf_hsl_evaluasi_kinerja'=>'hsl_evaluasi_kinerja_ '. ($index + 1) . '.pdf',
                    'approved' => $faker->randomElement(['0', '1']),
                    'tanggal_mulai'=>$tanggal_mulai,
                    'tanggal_selesai'=>$tanggal_selesai,
                    'status_periodik' => $status_periodik,
                    'status_selesai' => $faker->randomElement(['0', '1']),
                    'catatan'=>null,
                ]);
            } else {
                // Handle jika jenjang tidak ditemukan

            }
        }
    }


    public function findMaxPangkat($data, $target_jenjang_id, $ak_total, $ak_terakhir)
    {
        $targetElements = collect($data)->where('jenjang_id', $target_jenjang_id)->sortBy('pangkat_id');

        $result = [
            'pangkat_id_with_max_poin' => null,
            'pangkat_id_terakhir' => null,
            'max_pangkat_terakhir' => null,
            'selisih_poin' => 0,
            'selisih_poin_terakhir' => 0,
            'min_pangkat_terakhir' => null,
        ];

        // Find pangkat_id_with_max_poin based on $ak_total
        foreach ($targetElements as $targetElement) {
            if ($targetElement['max_standar_point'] === null) {
                $result['pangkat_id_with_max_poin'] = $targetElement['pangkat_id'];
                $result['selisih_poin'] = 0; // Set default value to 0 for the case when $ak_total is beyond the maximum standard point
                break;
            } elseif ($ak_total <= $targetElement['max_standar_point']) {
                $result['pangkat_id_with_max_poin'] = $targetElement['pangkat_id'];
                $result['selisih_poin'] = $ak_total - $targetElement['max_standar_point'];
                break;
            } else {
                // If $ak_total is greater than the maximum standar_point, set pangkat_id_with_max_poin to the current pangkat_id
                $result['pangkat_id_with_max_poin'] = $targetElement['pangkat_id'];
                $result['selisih_poin'] = 0;
            }
        }

        // Find pangkat_id_terakhir based on $ak_terakhir
        foreach ($targetElements as $targetElement) {
            if ($targetElement['max_standar_point'] === null) {
                $result['pangkat_id_terakhir'] = $targetElement['pangkat_id'];
                $result['selisih_poin_terakhir'] = 0; // Set default value to 0 for the case when $ak_terakhir is beyond the maximum standard point
                $result['max_pangkat_terakhir'] = $ak_terakhir;

                // Find the maximum standard point for the previous rank within the given 'jenjang_id'
                $previousRankElements = $targetElements->where('pangkat_id', $targetElement['pangkat_id'] - 1);
                $result['min_pangkat_terakhir'] = $previousRankElements->max('max_standar_point') ?? 0;

                break;
            } elseif ($ak_terakhir <= $targetElement['max_standar_point']) {
                $result['pangkat_id_terakhir'] = $targetElement['pangkat_id'];
                $result['selisih_poin_terakhir'] = $ak_terakhir - $targetElement['max_standar_point'];
                $result['max_pangkat_terakhir'] = $targetElement['max_standar_point'];

                // Find the maximum standard point for the previous rank within the given 'jenjang_id'
                $previousRankElements = $targetElements->where('pangkat_id', $targetElement['pangkat_id'] - 1);
                $result['min_pangkat_terakhir'] = $previousRankElements->max('max_standar_point') ?? 0;

                break;
            } else {
                // If $ak_terakhir is greater than the maximum standar_point, set pangkat_id_terakhir to the current pangkat_id
                $result['pangkat_id_terakhir'] = $targetElement['pangkat_id'];
                $result['selisih_poin_terakhir'] = 0;
                $result['max_pangkat_terakhir'] = $ak_terakhir;

                // Find the maximum standard point for the previous rank within the given 'jenjang_id'
                $previousRankElements = $targetElements->where('pangkat_id', $targetElement['pangkat_id'] - 1);
                $result['min_pangkat_terakhir'] = $previousRankElements->max('max_standar_point') ?? 0;
            }
        }

        return $result;
    }

    public function poinAKMaintainance()
    {
        $faker = Faker::create();
        $users = UserDetail::orderBy('id')->get();


        foreach ($users as $index => $user) {
            $jenjang = JenjangPangkat::with('poinKoefisienPerformances')->find($user->jenjang_id);
            if ($jenjang) {
                $pak = $user->ak_total;
                $pangkatResult = $this->calculatePangkatHelper($jenjang, $pak);
                LOG::info("pangkat result" . json_encode($pangkatResult));
                if (isset($pangkatResult['max_standar_point'])) {
                    $maxPangkatPoint = $pangkatResult['max_standar_point'];
                    $minPangkatPoint = $pangkatResult['previous_max_standar_point'] + 1;
                    //ak_terakhir
                    $ak_terakhir = mt_rand($minPangkatPoint, $maxPangkatPoint + 10);
                    $ak_terbaru = $faker->randomFloat(2, 1, 50);
                    $ak_total = $ak_terakhir + $ak_terbaru;
                    $maxJenjangPoint = $jenjang->poinKoefisienPerformances->max('max_standar_point');
                    $differenceJenjang = $maxJenjangPoint - $ak_total;
                    $selisihPoinJenjang = $ak_total - $maxJenjangPoint;
                    $selisihPoinPangkat = $ak_total - $maxPangkatPoint;
                    $test_passed = ($differenceJenjang >= 0) ? 0 : 1;
                    PoinAK::create([
                        'user_id' => $user->id,
                        'ak_terakhir' => $ak_terakhir,
                        'test_passed' => $test_passed,
                        'jenjang_id' => $user->jenjang_id,
                        'pangkat_id' => $pangkatResult['pangkat_id'],
                        'ak_terbaru' => $ak_terbaru,
                        'max_jenjang' => $maxJenjangPoint,
                        'max_pangkat' => $maxPangkatPoint,
                        'selisih_pangkat' => $selisihPoinPangkat,
                        'selisih_jenjang' => $selisihPoinJenjang,
                        'ak_total' => $ak_total,
                        'rating' => $faker->numberBetween(1, 5),
                        'pdf_file_evaluation' => 'evaluation_file_' . ($index + 1) . '.pdf',
                        'pdf_file_credit' => 'credit_file_' . ($index + 1) . '.pdf',
                        'approved' => $faker->randomElement(['0', '1']),
                    ]);
                } else {
                    // Handle the case where max_standar_point is not available
                }
            } else {
                // Handle jika jenjang tidak ditemukan

            }
        }
    }

    private function calculatePangkatHelper($jenjang, $pak)
    {
        $poinKoefisienPerformances = $jenjang->poinKoefisienPerformances;
        $pangkat = $poinKoefisienPerformances
            ->where('max_standar_point', '>=', $pak)
            ->sortBy('max_standar_point')
            ->first();

        if (!$pangkat) {
            $pangkat = $poinKoefisienPerformances->last();
        }

        $previousPangkat = $poinKoefisienPerformances
            ->where('max_standar_point', '<', $pangkat->max_standar_point)

            ->first();

        return [
            'max_standar_point' => $pangkat->max_standar_point ?? null,
            'previous_max_standar_point' => $previousPangkat ? $previousPangkat->max_standar_point + 10 : 0,
            'pangkat_id' => $pangkat->pangkat_id,
        ];
    }


}
