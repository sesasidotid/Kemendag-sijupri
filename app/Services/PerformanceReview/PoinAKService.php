<?php

namespace App\Services\PerformanceReview;

use App\Models\JenjangPangkat;
use App\Models\PangkatGolongan;
use App\Models\PoinAK;
use App\Models\PoinKoefisienPerformance;
use App\Models\UserDetail;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PoinAKService
{
    //DONE - ADMIN - GET ALL
    public function getAllPoinAKs()
    {
        return PoinAK::orderBy('id', 'asc')->get();
    }

    //DONE - ADMIN - GET USER BY ID
    public function getPoinAKsForUser($userId)
    {
        return PoinAK::with(['user.userDetail', 'jabatan', 'jenjang', 'pangkat', 'riwayatJabatan', 'pangkatRekom'])
            ->where('user_id', $userId)
            ->get();
    }
    //DONE - ADMIN - VERIFIKASI BY ID
    public function changeStatusVerifikasi($id, $status)
    {
        try {
            $poinAK = PoinAK::find($id);

            if ($poinAK) {
                $poinAK->approved = $status;
                $poinAK->save();

                $message = $status ? 'Approved' : 'Disapproved';
                return ['success' => true, 'message' => $message . ' successfully'];
            } else {
                return ['success' => false, 'message' => 'Record not found'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    //DONE - ADMIN - STATUS SELESAI BY ID
    public function changeStatusSelesai($id, $status)
    {
        try {
            $poinAK = PoinAK::find($id);

            if ($poinAK) {
                $poinAK->status_selesai = $status;
                $poinAK->save();

                $message = $status ? 'Approved' : 'Disapproved';
                return ['success' => true, 'message' => $message . ' successfully'];
            } else {
                return ['success' => false, 'message' => 'Record not found'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    //DONE - ADMIN - UPDATE/EDIT ANGKA KREDIT
    public function updateAngkaKredit(PoinAK $poinAK, array $data): bool
    {
        try {
            $poinAK->update($data);
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return false;
        }
    }
    //DONE - ADMIN - TAMPIL KOEFISIEN
    public function getKoefisienData()
    {
        try {
            $jenjangs = JenjangPangkat::pluck('jenjang', 'id')->unique();
            $pangkats = PangkatGolongan::pluck('pangkat', 'id')->unique();
            $koefisiens = PoinKoefisienPerformance::with(['jenjangPangkat', 'pangkatGolongan'])->get();
            return compact('koefisiens', 'jenjangs', 'pangkats');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return [];
        }
    }

    //DONE - USER - TAMBAHKAN ANGKA KREDIT TERBARU
    public function processForm(Request $request, Guard $auth)
    {
        $validatedData = $this->validateFormData($request);
        $userJF = $auth->user();
        $userId = $userJF->id;
        $user = $userJF->userDetail;
        $jenjang = $user->userJabatan->jenjang;

        $ak_terakhir = $validatedData['ak_terakhir'] ?? 0;
        $ak_total = $ak_terakhir + ($validatedData['ak_terbaru'] ?? 0);

        $pdfFileAkTerakhir = $this->handleFileUpload($request, 'pdf_dokumen_ak_terakhir', $user);
        $pdfFileEvaluasi = $this->handleFileUpload($request, 'pdf_hsl_evaluasi_kinerja', $user);
        $pdfFileAkumulasi = $this->handleFileUpload($request, 'pdf_akumulasi_ak_konversi', $user);

        $maxJenjangElement = $jenjang->puncak_jenjang;
        if ($maxJenjangElement === null) {
            $selisih_jenjang = null;
        } else {
            $selisih_jenjang = $ak_total - $maxJenjangElement;
        }

        PoinAK::updateOrCreate(
            ['user_id' => $user->id],
            $this->buildDatabaseRecord($validatedData, $pdfFileAkTerakhir, $pdfFileEvaluasi, $pdfFileAkumulasi, $user, $selisih_jenjang, $maxJenjangElement)
        );
    }

    //DONE - USER - VALIDASI FORM TAMBAH
    private function validateFormData(Request $request)
    {
        return $request->validate([
            'ak_terakhir' => 'required',
            'pdf_dokumen_ak_terakhir' => 'required|mimes:pdf|max:2048',
            'ak_terbaru' => 'required|numeric',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status_periodik' => 'required',
            'rating' => 'required',
            'pdf_hsl_evaluasi_kinerja' => 'required|mimes:pdf|max:2048',
            'pdf_akumulasi_ak_konversi' => 'required|mimes:pdf|max:2048',
        ]);
    }

    //DONE - USER - HANDLE FILES UPLOAD PDF
    private function handleFileUpload(Request $request, $fieldName, $user, $folder = 'pdfs')
    {
        if (!$user) {
            abort(401, 'Unauthorized');
        }
        $file = $request->file($fieldName);
        if ($file) {
            $nip = $user->nip;
            $newFilename = $nip . '_' . $fieldName . '.pdf';
            $path = $folder;
            $storedPath = $file->storeAs($path, $newFilename, 'public');

            return $storedPath;
        }
        return null;
    }

    //DONE - USER - KIRIM KE DATABASE
    private function buildDatabaseRecord($validatedData, $pdfFileAkTerakhir, $pdfFileEvaluasi, $pdfFileAkumulasi, $user, $selisihJenjang, $puncakJenjang)
    {

        return [
            'ak_terakhir' => $validatedData['ak_terakhir'],
            'ak_terbaru' => $validatedData['ak_terbaru'],
            'ak_total' => $validatedData['ak_terakhir'] + $validatedData['ak_terbaru'],

            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],

            'status_periodik' => $validatedData['status_periodik'],
            'rating' => $validatedData['rating'],

            'pdf_hsl_evaluasi_kinerja' => $pdfFileEvaluasi,
            'pdf_akumulasi_ak_konversi' => $pdfFileAkumulasi,
            'pdf_dokumen_ak_terakhir' => $pdfFileAkTerakhir,


            'jenjang_code' => $user->userJabatan->jenjang_code,
            'pangkat_id' => $user->userPangkat->pangkat_id,
            'jabatan_code' => $user->userJabatan->jabatan_code,

            'selisih_jenjang' => $selisihJenjang,
            'max_jenjang' => $puncakJenjang,

        ];
    }









    //-----------------------------------------------------MAINTAINANCE---------------------------------------------------------------------------

    //MAINTAINANCE
    public function processFormMaintainance(Request $request, Guard $auth)
    {
        $validatedData = $this->validateFormData($request);
        $userJF = $auth->user();
        $userId = $userJF->id;
        $user = UserDetail::where('id', $userId)->first();
        $jenjang = JenjangPangkat::where('id', $user->jenjang_id)->first();

        $ak_terakhir = $validatedData['ak_terakhir'] ?? 0;
        $ak_total = $ak_terakhir + ($validatedData['ak_terbaru'] ?? 0);

        $pdfFileAkTerakhir = $this->handleFileUpload($request, 'pdf_dokumen_ak_terakhir', $user);
        $pdfFileEvaluasi = $this->handleFileUpload($request, 'pdf_hsl_evaluasi_kinerja', $user);
        $pdfFileAkumulasi = $this->handleFileUpload($request, 'pdf_akumulasi_ak_konversi', $user);

        $maxJenjangElement = $jenjang->puncak_jenjang;
        if ($maxJenjangElement === null) {
            $selisih_jenjang = null;
        } else {
            $selisih_jenjang = $ak_total - $maxJenjangElement;
        }

        PoinAK::updateOrCreate(
            ['user_id' => $user->id],
            $this->buildDatabaseRecord($validatedData, $pdfFileAkTerakhir, $pdfFileEvaluasi, $pdfFileAkumulasi, $user, $selisih_jenjang, $maxJenjangElement)
        );
    }
    //MAINTAINANCE
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
    //MAINTAINANCE
    private function calculateMaxJenjangElement($data, $user, $result)
    {
        $maxJenjangElement = null;
        $maxPangkatElement = null;

        if ($result['pangkat_id_with_max_poin'] !== null) {
            $maxJenjangElement = collect($data)
                ->where('jenjang_id', $user->jenjang_id)
                ->max('max_standar_point');

            $maxPangkatElement = collect($data)
                ->where('pangkat_id', $result['pangkat_id_with_max_poin'])
                ->max('max_standar_point');

            if (($user->jenjang_id === 8 && $result['pangkat_id_with_max_poin'] === 17) || ($user->jenjang_id === 4 && $result['pangkat_id_with_max_poin'] === 8)) {
                $maxJenjangElement = $maxPangkatElement;
            }
        }

        return ['maxJenjang' => $maxJenjangElement, 'maxPangkat' => $maxPangkatElement];
    }
    //MAINTAINANCE
    private function handleFileUploadMaintainance(Request $request, $fieldName, $folder = 'pdfs')
    {
        $file = $request->file($fieldName);

        if ($file) {
            $filename = $file->storeAs($folder, $file->getClientOriginalName(), 'public');
            return $filename;
        }

        return null;
    }
    //MAINTAINANCE
    public function getUserPointsFormData()
    {
        $user = UserDetail::find(2);
        $user_id = $user->id;

        return compact('user_id', 'user');
    }

    //MAINTAINANCE
    public function calculateUserPoints($request)
    {
        $user = UserDetail::find(2);
        $user_id = $user->id;
        $startTrainingDate = Carbon::create(2023, 6, 10);
        $inputYears = $request->input('years', 1);
        $points = $request->input('points', 0);
        $endDate = $startTrainingDate->copy()->addYears($inputYears);
        $yearsPassed = max(0, $startTrainingDate->diffInYears($endDate));

        $userData = PoinAK::where('user_id', $user_id)->with(['user.userDetail', 'jenjang', 'pangkat'])->first();

        if ($userData) {
            $oldPoints = $userData->points;
            $initialSkillLevel = 0;

            $currentPosition = optional($userData->jenjang)->jenjang;
            $currentPangkat = optional($userData->pangkat)->pangkat;
            $oldPoints = $userData->points;
            $finalSkillLevel = $initialSkillLevel + $points * $yearsPassed;

            $totalPoints = $oldPoints + $request->input('points') + $finalSkillLevel;

            $jenjang = PoinKoefisienPerformance::find($user->jenjang_id);
            $maxStandarJenjangPoint = $this->findMaxStandarPointJenjangById($jenjang->id);
            $maxStandarPangkatPoint = $this->findMaxStandarPointPangkatyId($jenjang->id);

            if ($finalSkillLevel >= 100) {
                $testResult = rand(0, 1);
                if ($testResult) {
                    $currentPosition = 'UTAMA';
                    $finalSkillLevel = 0;
                }
            }

            $allProperties = $userData->getAttributes();

            return [
                'totalPoints' => $totalPoints,
                'userData' => $userData,
                'maxStandarPangkatPoint' => $maxStandarPangkatPoint,
                'maxStandarJenjangPoint' => $maxStandarJenjangPoint,
                'allProperties' => $allProperties,
                'additionalData' => [
                    'yearsPassed' => $yearsPassed,
                    'initialSkillLevel' => $initialSkillLevel,
                    'finalSkillLevel' => $finalSkillLevel,
                    'oldPoints' => $userData->points,
                    'startDate' => $startTrainingDate->toDateString(),
                    'endDate' => $endDate->toDateString(),
                    'currentPosition' => $currentPosition,
                    'currentPangkat' => $currentPangkat,
                ],
            ];
        } else {
            return ['error' => 'User data not found.'];
        }
    }
    //MAINTAINANCE
    protected function findMaxStandarPointJenjangById($jenjangId)
    {
        $maxStandarPoint = PoinKoefisienPerformance::where('jenjang_id', function ($query) use ($jenjangId) {
            $query->select('id')->from('tbl_koefisien_poin_performance')->where('id', $jenjangId);
        })->max('max_standar_point');

        return $maxStandarPoint;
    }
    //MAINTAINANCE
    protected function findMaxStandarPointPangkatyId($jenjangId)
    {
        $maxStandarPoint = PoinKoefisienPerformance::where('pangkat_id', function ($query) use ($jenjangId) {
            $query->select('id')->from('tbl_koefisien_poin_performance')->where('id', $jenjangId);
        })->max('max_standar_point');

        return $maxStandarPoint;
    }

    //MAINTAINANCE
    public function calculatePangkat($jenjang_id, $point)
    {
        $jenjang = JenjangPangkat::with('poinKoefisienPerformances')->find($jenjang_id);

        if (!$jenjang) {
            return "Jenjang not found.";
        }

        $poinKoefisienPerformances = $jenjang->poinKoefisienPerformances;

        $pangkat = $poinKoefisienPerformances
            ->where('max_standar_point', '>=', $point)
            ->sortBy('max_standar_point')
            ->first();

        if (!$pangkat) {
            $pangkat = $poinKoefisienPerformances->last();
        }

        if ($point > $pangkat->max_standar_point || $pangkat->max_standar_point === null) {
            $nextPangkat = $poinKoefisienPerformances
                ->where('pangkat_id', '>', $pangkat->pangkat_id)
                ->whereNotNull('max_standar_point')
                ->sortBy('max_standar_point')
                ->first();

            if ($nextPangkat) {
                $pangkat = $nextPangkat;
            }
        }

        $differencePangkat = $point - $pangkat->max_standar_point;
        $differenceJenjang = $point - $poinKoefisienPerformances->max('max_standar_point');

        if ($pangkat->pangkat_id == 8 || $pangkat->pangkat_id == 17) {
            $differencePangkat = $differenceJenjang;
        }

        $jenjangNames = JenjangPangkat::pluck('jenjang', 'id')->toArray();
        $jenjangNama = JenjangPangkat::where('id', $jenjang_id)->value('jenjang');
        $pangkat_id = $pangkat->pangkat_id;
        $pangkatNama = PangkatGolongan::where('id', $pangkat_id)->value('pangkat');

        return [
            'jenjang_id' => $jenjang_id,
            'jenjang' => $jenjangNama,
            'point' => $point,
            'pangkat' => $pangkatNama,
            'differencePangkat' => $differencePangkat,
            'differenceJenjang' => $differenceJenjang,
            'pangkat_id' => $pangkat_id,
            'pangkatNama' => $pangkatNama,
            'jenjangNames' => $jenjangNames
        ];
    }
    //MAINTAINANCE
    public function downloadPAK($file)
    {
        log::info("file:" . $file);
        $path = "public/pdfs/$file"; // Include 'public/' in the path
        log::info("path:" . $path);
        if (Storage::exists($path)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            return response()->file(storage_path("app/$path"), $headers);
        } else {
            abort(404, 'File not found');
        }
        //relative path: storage\app\public\pdfs\495290006482702845_pdf_dokumen_ak_terakhir.pdf
        //file: 495290006482702845_pdf_dokumen_ak_terakhir.pdf
    }
}
