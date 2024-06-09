<?php

namespace App\Http\Controllers\AKP\Service;

use App\Enums\AkpStatus;
use App\Enums\TaskStatus;
use App\Http\Controllers\SearchService;
use App\Models\AKP\Akp;
use App\Models\User;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class AkpService extends Akp
{
    use SearchService;
    private const PERIODE = 3;
    private const MULAI_PERIODE = '2023';


    public function generateAkp(array $akpNew, $akp_status)
    {
        $currentYear = now()->year;
        $isNewPeriod = true;
        $this->findByNip($akpNew['nip']);

        $akp = $this->findActiveAKP($akpNew['nip'], $akp_status);

        // if ($akp) {
        //     $lastPeriodStart = Date::parse($akp->tanggal_mulai)->year;
        //     $lastPeriodEnd = Date::parse($akp->tanggal_selesai)->year;
        //     if ($currentYear >= $lastPeriodStart && $currentYear <= $lastPeriodEnd) {
        //         $isNewPeriod = false;
        //     }
        // }

        if (!$akp) {
            $currentEventStartYear =  $this::MULAI_PERIODE + floor(($currentYear -  $this::MULAI_PERIODE) / $this::PERIODE) * $this::PERIODE;
            $currentEventEndYear = $currentEventStartYear + ($this::PERIODE - 1);
            $akpNew['tanggal_mulai'] = ((string)$currentEventStartYear) . '-01-01';
            $akpNew['tanggal_selesai'] = ((string)$currentEventEndYear) . '-01-01';

            $this->fill($akpNew);
            $this->akp_status = $akp_status;
            return $this->customSave();
        } else {
            $akp->fill($akpNew);
            $akp->akp_status = AkpStatus::ATASAN_REKAN_REVIEWED;
            return $akp->customUpdate();
        }
    }

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->get();
    }

    public function findById($id): ?AkpService
    {
        return $this
            ->where('id', $id)
            ->where('delete_flag', false)
            ->first();
    }

    public function findByNip($nip)
    {
        return $this
            ->where('nip', $nip)
            ->where('delete_flag', false)
            ->whereIn('akp_status', [AkpStatus::REVIEWED, AkpStatus::ATASAN_REKAN_REVIEWED])
            ->get();
    }

    public function findActiveAKP($nip, $akp_status): ?AkpService
    {
        return $this
            ->where('nip', $nip)
            ->whereNotIn('akp_status', [AkpStatus::REVIEWED, AkpStatus::ATASAN_REKAN_REVIEWED, $akp_status])
            // ->latest('tanggal_mulai')
            ->first() ?? null;
    }

    public function customSave()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip ?? '';
            $this->save();

            return $this;
        });
    }

    public function saveUpdateScoreWithMatrixAKP(array $akpNew, array $akpMatrixNew)
    {
        DB::transaction(function () use ($akpNew, $akpMatrixNew) {
            $matrixAKPList = $this->akpMatrix;

            foreach ($matrixAKPList as $key => $value) {
                //matrix 1
                $akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_1'] =
                    ($akpMatrixNew[$value->akp_pertanyaan_id]['ybs'] ?? 0) +
                    ($value->atasan ?? 0) +
                    ($value->rekan ?? 0);

                if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_1'] <= 3) {
                    $akpMatrixNew[$value->akp_pertanyaan_id]['keterangan_matrix_1'] = 'DKK';
                } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_1'] <= 6) {
                    $akpMatrixNew[$value->akp_pertanyaan_id]['keterangan_matrix_1'] = 'DKK (non training)';
                } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_1'] >= 7) {
                    $akpMatrixNew[$value->akp_pertanyaan_id]['keterangan_matrix_1'] = 'non DKK';
                }

                if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_1'] < 7) {
                    //matrix 2
                    if ($akpMatrixNew[$value->akp_pertanyaan_id]['materi'] == 1) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['penyebab_diskrepansi_utama'] = "Penguasaan Materi";
                        $akpMatrixNew[$value->akp_pertanyaan_id]['jenis_pengembangan_kompetensi'] = "Pelatihan Teknis";
                    } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['penugasan'] == 1) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['penyebab_diskrepansi_utama'] = "Penunjang Kegiatan";
                        $akpMatrixNew[$value->akp_pertanyaan_id]['jenis_pengembangan_kompetensi'] = "Magang";
                    } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['informasi'] == 1) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['penyebab_diskrepansi_utama'] = "Informasi";
                        $akpMatrixNew[$value->akp_pertanyaan_id]['jenis_pengembangan_kompetensi'] = "Seminar/Bimtek/Belajar Mandiri";
                    }

                    //matrix 3
                    $akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_3'] =
                        ($akpMatrixNew[$value->akp_pertanyaan_id]['waktu'] ?? 0) +
                        ($akpMatrixNew[$value->akp_pertanyaan_id]['kesulitan'] ?? 0) +
                        ($akpMatrixNew[$value->akp_pertanyaan_id]['kualitas'] ?? 0) +
                        ($akpMatrixNew[$value->akp_pertanyaan_id]['pengaruh'] ?? 0);

                    if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_3'] <= 9) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['kategori_matrix_3'] = "Diskrepansi Tinggi";
                    } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_3'] <= 14) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['kategori_matrix_3'] = "Diskrepansi Sedang";
                    } else if ($akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_3'] >= 25) {
                        $akpMatrixNew[$value->akp_pertanyaan_id]['kategori_matrix_3'] = "Diskrepansi Rendah";
                    }
                } else {
                    $akpMatrixNew[$value->akp_pertanyaan_id]['score_matrix_3'] = 0;
                }
            }

            $ranks = array_column($akpMatrixNew, 'score_matrix_3');
            uasort($akpMatrixNew, function ($item1, $item2) {
                return ($item1['score_matrix_3'] ?? PHP_INT_MAX) - ($item2['score_matrix_3'] ?? PHP_INT_MAX);
            });


            $rank = 1;
            foreach ($akpMatrixNew as &$item) {
                if ($item['score_matrix_3'] != 0)
                    $item['rank_prioritas_matrix_3'] = $rank++;
            }

            $this->fill($akpNew);
            $this->task_status = TaskStatus::PENDING;
            $this->akp_status = AkpStatus::REVIEWED;
            $this->customUpdate();

            $akpMatrix = new AkpMatrixService();
            $akpMatrix->updateAllByAkpIdAndPertanyaanAkpId($akpMatrixNew, $this->id);
        });
    }

    public function customUpdate()
    {
        return DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip ?? '';
            $this->save();
            return $this;
        });
    }

    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip;
            $this->delete_flag = true;
            $this->save();
        });
    }
}
