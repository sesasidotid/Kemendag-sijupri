<?php

namespace Eyegil\SijupriMaintenance\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Eyegil\Base\Pageable;
use Eyegil\SijupriMaintenance\Dtos\SuratRekomTemplateDto;
use Eyegil\SijupriMaintenance\Models\Counter;
use Eyegil\SijupriMaintenance\Models\SuratRekomProcess;
use Eyegil\SijupriMaintenance\Models\SuratRekomTemplate;
use Eyegil\SijupriUkom\Models\UkomGrade;
use Eyegil\SijupriUkom\Services\ParticipantUkomService;
use Eyegil\Base\Exceptions\BusinessException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SuratRekomTemplateService
{

    private const CODE = "REKOM_UKOM";

    public function __construct(
        private ParticipantUkomService $participantUkomService,
        private CounterService $counterService
    ) {
    }

    public function findSearch(Pageable $pageable)
    {
        return $pageable->setOrderQueries(function (Pageable $instance, $query) {
            if (empty($instance->sort)) {
                $query->orderBy($instance->getTable() . '.date_created', 'desc');
            }
        })->search(SuratRekomProcess::class);
    }

    public function findTemplate($code)
    {
        return SuratRekomTemplate::findOrThrowNotFound($code);
    }

    public function download(string $id)
    {
        $suratRekomProcess = SuratRekomProcess::where("status", "FINISHED")
            ->where("id", $id)->firstOrThrowNotFound();

        return storage_path('app/rekom/' . $suratRekomProcess->file_name);
    }

    public function delete(string $id)
    {
        DB::transaction(function () use ($id) {
            $suratRekomProcess = SuratRekomProcess::where("status", "FINISHED")
                ->where("id", $id)->firstOrThrowNotFound();

            $rarFilePath = storage_path('app/rekom' . $suratRekomProcess->file_name ?? '');
            if (file_exists($rarFilePath)) {
                unlink($rarFilePath);
            }

            $suratRekomProcess->delete();
        });
    }

    public function setUpRekom(SuratRekomTemplateDto $suratRekomTemplateDto)
    {
        DB::transaction(function () use ($suratRekomTemplateDto) {
            $suratRekomTemplate = SuratRekomTemplate::findOrThrowNotFound($suratRekomTemplateDto->code);

            $result = $suratRekomTemplate->base_template;
            foreach ($suratRekomTemplateDto->parameters as $key => $parameter) {
                $result = str_replace('{{$' . $key . '}}', $parameter, $result);
            }

            $suratRekomTemplate->template = $result;
            $suratRekomTemplate->save();
        });
    }

    public function generateUkomRekom()
    {
        $ukomGradeList = UkomGrade::with([
            "participantUkom.pendidikanTerakhir",
            "participantUkom.nextJabatan",
            "participantUkom.nextJenjang",
            "participantUkom.unitKerja.instansi",
            "participantUkom.pangkat"
        ])
            ->whereHas("participantUkom", function ($query) {
                $query->whereNull("rekomendasi");
            })->where("passed", true)
            ->get();

        $suratRekomTemplate = SuratRekomTemplate::findOrThrowNotFound(self::CODE);

        $files = [];
        try {
            if ($ukomGradeList->isEmpty()) {
                throw new BusinessException("nothing to generate", "");
            }

            $rarFileName = Carbon::now()->format('Ymd_His') . '.rar';

            $suratRekomProcess = new SuratRekomProcess();
            $suratRekomProcess->type = "generate_ukom";
            $suratRekomProcess->status = "IN_PROCESS";
            $suratRekomProcess->file_name = $rarFileName;
            $suratRekomProcess->saveWithUUid();

            foreach ($ukomGradeList as $key => $ukomGrade) {
                $template = $suratRekomTemplate->template;

                $num_code2 = $this->counterService->counter(self::CODE, function (Counter $counter) {
                    // return Carbon::parse($counter->last_updated)->isCurrentYear();
                    return false;
                });

                $nip = $ukomGrade->participantUkom->nip;
                $name = $ukomGrade->participantUkom->name;
                $pangkat = $ukomGrade->participantUkom->pangkat->name;
                $golongan = $ukomGrade->participantUkom->pangkat->golongan;
                $tmt_pangkat = $ukomGrade->participantUkom->tmt_pangkat;
                $pendidikan = optional($ukomGrade->participantUkom->pendidikanTerakhir)->name;
                $tempat_lahir = $ukomGrade->participantUkom->tempat_lahir;
                $tanggal_lahir = $ukomGrade->participantUkom->tanggal_lahir;
                $jabatan_fungsional = optional($ukomGrade->participantUkom->nextJabatan)->name;
                $tmt_jabatan = $ukomGrade->participantUkom->tmt_jabatan;
                $unit_kerja_name = $ukomGrade->participantUkom->unit_kerja_name;

                $instansi_name = '';


                if ($ukomGrade->participantUkom->unitKerja && $ukomGrade->participantUkom->unitKerja->instansi) {
                    $instansi = $ukomGrade->participantUkom->unitKerja;

                    if ($instansi->instansi_type_code == "IT1") {
                        $instansi_name = "Kementerian perdagangan";
                    } else if ($instansi->instansi_type_code == "IT2") {
                        $instansi_name = $instansi->name;
                    } else if ($instansi->instansi_type_code == "IT3") {
                        $instansi_name = "Pemerintahan daerah provinsi " . $instansi->provinsi->name;
                    } else if ($instansi->instansi_type_code == "IT4") {
                        $instansi_name = "Pemerintahan daerah kabupaten " . $instansi->kabupaten->name;
                    } else if ($instansi->instansi_type_code == "IT5") {
                        $instansi_name = "Pemerintahan daerah kota " . $instansi->kota->name;
                    }
                } else {
                    $provinsi = $ukomGrade->participantUkom->provinsi;
                    $kabupatenKota = $ukomGrade->participantUkom->kabupatenKota;

                    if ($provinsi) {
                        $instansi_name = "Pemerintahan daerah provinsi " . $provinsi->name;
                    }
                    if ($kabupatenKota) {
                        if ($kabupatenKota->type == "KABUPATEN") {
                            $instansi_name = "Pemerintahan daerah kabupaten " . $kabupatenKota->name;
                        } else {
                            $instansi_name = "Pemerintahan daerah kota " . $kabupatenKota->name;
                        }
                    }
                }

                if (empty($instansi_name)) {
                    $instansi_name = ucwords(str_replace('_', ' ', strtolower($ukomGrade->participantUkom->jenis_instansi ?? '')));
                }

                if ($ukomGrade->ukmsk == null && $ukomGrade->score == null) {
                    $teknis_percentage = '100';
                    $mansoskul_percentage = '0';
                    $nilai_teknis = $ukomGrade->ukt;
                    $bobot_teknis = $ukomGrade->nb_ukt;
                    $nilai_manajerial = '-';
                    $bobot_manajerial = '-';
                } else {
                    $teknis_percentage = '50';
                    $mansoskul_percentage = '50';
                    $nilai_teknis = $ukomGrade->ukt;
                    $bobot_teknis = $ukomGrade->nb_ukt;
                    $nilai_manajerial = $ukomGrade->jpm;
                    $bobot_manajerial = $ukomGrade->ukmsk;
                }

                $nilai_akhir = $ukomGrade->grade;
                $jabatan_tujuan = $ukomGrade->participantUkom->nextJabatan->name;
                $jenjang_tujuan = $ukomGrade->participantUkom->nextJenjang->name;

                $template = str_replace('{{$num_code2}}', $num_code2, $template);
                $template = str_replace('{{$nip}}', $nip, $template);
                $template = str_replace('{{$name}}', $name, $template);
                $template = str_replace('{{$pangkat}}', $pangkat, $template);
                $template = str_replace('{{$golongan}}', $golongan, $template);
                $template = str_replace('{{$tmt_pangkat}}', $tmt_pangkat, $template);
                $template = str_replace('{{$pendidikan}}', $pendidikan, $template);
                $template = str_replace('{{$tempat_lahir}}', $tempat_lahir, $template);
                $template = str_replace('{{$tanggal_lahir}}', $tanggal_lahir, $template);
                $template = str_replace('{{$jabatan_fungsional}}', $jabatan_fungsional, $template);
                $template = str_replace('{{$tmt_jabatan}}', $tmt_jabatan, $template);
                $template = str_replace('{{$unit_kerja_name}}', $unit_kerja_name, $template);
                $template = str_replace('{{$instansi_name}}', $instansi_name, $template);
                $template = str_replace('{{$nilai_teknis}}', $nilai_teknis, $template);
                $template = str_replace('{{$nilai_manajerial}}', $nilai_manajerial, $template);
                $template = str_replace('{{$bobot_teknis}}', $bobot_teknis, $template);
                $template = str_replace('{{$bobot_manajerial}}', $bobot_manajerial, $template);
                $template = str_replace('{{$nilai_akhir}}', $nilai_akhir, $template);
                $template = str_replace('{{$jabatan_tujuan}}', $jabatan_tujuan, $template);
                $template = str_replace('{{$jenjang_tujuan}}', $jenjang_tujuan, $template);
                $template = str_replace('{{$teknis_percentage}}', $teknis_percentage, $template);
                $template = str_replace('{{$mansoskul_percentage}}', $mansoskul_percentage, $template);

                $file = storage_path('app/temp');
                if (!file_exists($file)) {
                    mkdir($file, 0755, true);
                }
                $file = storage_path("app/temp/$nip.pdf");
                $pdf = Pdf::loadHTML($template)->setPaper('a4', 'portrait');
                $pdf->save($file);
                $files[] = $file;
            }

            $directory = storage_path('app/rekom');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $rarFile = $directory . '/' . $rarFileName;
            $fileList = implode(' ', array_map('escapeshellarg', $files));
            $rarFileEscaped = escapeshellarg($rarFile);

            exec("rar a $rarFileEscaped $fileList", $output, $resultCode);

            if ($resultCode !== 0) {
                throw new \Exception("Failed to create RAR archive");
            }

            $suratRekomProcess->status = "FINISHED";
            $suratRekomProcess->save();

        } catch (\Throwable $th) {
            $suratRekomProcess->status = "FAILED";
            $suratRekomProcess->save();

            throw $th;
        } finally {
            foreach ($files as $key => $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }

    public function uploadRekomendasiUkomBatch($compressed_file_base64)
    {


        $suratRekomProcess = new SuratRekomProcess();
        $suratRekomProcess->type = "generate_ukom";
        $suratRekomProcess->status = "IN_PROCESS";
        $suratRekomProcess->file_name = null;
        $suratRekomProcess->saveWithUUid();

        DB::transaction(function () use ($compressed_file_base64, $suratRekomProcess) {

            // temp unique file name
            $compressed_file_base64 = preg_replace('#^data:.*?;base64,#', '', $compressed_file_base64);

            // temp unique file name
            $rarFileName = Str::uuid() . '.rar';
            $rarFilePath = storage_path('app/temp/' . $rarFileName);
            $extractPath = storage_path('app/temp/extracted_' . Str::uuid());

            try {
                // decode base64
                $rarData = base64_decode($compressed_file_base64);

                // ensure temp dir exists
                if (!file_exists(storage_path('app/temp'))) {
                    mkdir(storage_path('app/temp'), 0777, true);
                }

                // save .rar temporarily
                file_put_contents($rarFilePath, $rarData);
                Log::info('Rar file saved to: ' . $rarFilePath);

                // extract
                mkdir($extractPath, 0777, true);

                // use unrar (server must have unrar installed)
                $command = "unrar x -y " . escapeshellarg($rarFilePath) . " " . escapeshellarg($extractPath);
                shell_exec($command);

                // move pdfs
                $files = glob($extractPath . '/*.pdf');
                $destinationPath = storage_path('app/buckets/ukom');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                foreach ($files as $file) {
                    $filename = basename($file);
                    Log::info('' . $filename);
                    $participantUkom = $this->participantUkomService->findByNipOrEmailLatest(str_replace('.pdf', '', $filename));
                    if (!$participantUkom) {
                        continue;
                    }

                    $participantUkom->rekomendasi = "file_rekomendasi_" . $participantUkom->id . ".pdf";
                    $participantUkom->save();

                    rename($file, $destinationPath . '/' . $participantUkom->rekomendasi);
                }

                $suratRekomProcess->status = "FINISHED";
                $suratRekomProcess->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'RAR extracted and PDFs saved.',
                    'pdf_count' => count($files)
                ]);
            } catch (\Throwable $th) {
                $suratRekomProcess->status = "FAILED";
                $suratRekomProcess->save();

                throw $th;
            } finally {
                if (file_exists($rarFilePath)) {
                    unlink($rarFilePath);
                }
                $this->deleteDir($extractPath);
            }
        });
    }

    private function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return;
        }
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                $filePath = $dirPath . DIRECTORY_SEPARATOR . $object;
                if (is_dir($filePath)) {
                    $this->deleteDir($filePath);
                } else {
                    unlink($filePath);
                }
            }
        }
        rmdir($dirPath);
    }
}