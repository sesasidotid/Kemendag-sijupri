<?php

namespace App\Http\Controllers\Ukom\Service;

use App\Enums\TaskStatus;
use App\Http\Controllers\Maintenance\Service\StorageService;
use App\Http\Controllers\SearchService;
use App\Models\Maintenance\SystemConfiguration;
use App\Models\Ukom\Ukom;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UkomService extends Ukom
{
    use SearchService;

    private const bucket_name = "ukom";

    public function findAllPeriodeBaru($periode, $data)
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('periode_ukom', $periode)
            ->where('tipe_ukom', 'baru')
            ->where('jenis_ukom', $data)
            ->get();
    }

    public function findAllPeriodeMengulang($periode, $data)
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('periode_ukom', $periode)
            ->where('tipe_ukom', 'mengulang')
            ->where('jenis_ukom', $data)
            ->get();
    }

    public function findAllByTaskStatus($task_status)
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->where('task_status', $task_status)
            ->get();
    }

    public function findAll()
    {
        return $this
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
    }

    public function findAllPendingMengulang($id, $data)
    {
        return $this

            ->where('tipe_ukom', 'mengulang')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', NULL)
            ->get();
    }

    public function findAllPendingSanggah($id, $data)
    {
        return $this

            ->where('tipe_ukom', 'baru')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('sanggah', 1)
            ->get();
    }

    public function findAllPendingSanggahMengulang($id, $data)
    {
        return $this
            ->where('tipe_ukom', 'mengulang')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('sanggah', 1)
            ->get();
    }

    public function findAllPendingBaru($id, $data)
    {
        return $this
            ->where('tipe_ukom', 'baru')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', NULL)
            ->get();
    }

    public function findAllDiterimaBaru($id, $data)
    {
        return $this
            ->where('tipe_ukom', 'baru')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', TaskStatus::APPROVE)
            ->get();
    }

    public function findAllDiterimaMengulang($id, $data)
    {
        return $this
            ->where('tipe_ukom', 'mengulang')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', TaskStatus::APPROVE)
            ->get();
    }

    public function   findAllDitolak($id, $data)
    {
        return $this

            ->where('tipe_ukom', 'baru')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', TaskStatus::REJECT)
            ->where('sanggah', NULL)
            ->get();
    }

    public function   findAllDitolakMengulang($id, $data)
    {
        return $this

            ->where('tipe_ukom', 'mengulang')
            ->where('jenis_ukom', $data)
            ->where('periode_ukom', $id)
            ->where('task_status', TaskStatus::REJECT)
            ->where('sanggah', NULL)
            ->get();
    }

    public function findById($id): ?UkomService
    {
        return $this
            ->where('id', $id)
            ->first();
    }

    public function findByNip($nip)
    {
        return $this->where('nip', $nip)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function findLatestByEmailAndJenisUkom($email, $jenis): ?UkomService
    {
        return $this
            ->where('email', $email)
            ->where('jenis', $jenis)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function findByPendaftaranCode($pendaftaran_code): ?UkomService
    {
        return $this->where('pendaftaran_code', $pendaftaran_code)
            ->first();
    }

    public function findByNipAndStatusNot($nip, $status): ?UkomService
    {
        return $this
            ->where('nip', $nip)
            ->where('status', '!=', $status)
            ->first();
    }

    public function findByStatusNot($status)
    {
        return $this
            ->where('status', '!=', $status)
            ->get();
    }

    public function findByUkomPeriodeIdAndNipOrEmail($ukom_periode_id, $nip_email): ?UkomService
    {
        return $this
            ->where('ukom_periode_id', $ukom_periode_id)
            ->where(function ($query) use ($nip_email) {
                $query->where('nip', $nip_email);
                $query->orWhere('email', $nip_email);
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function cekUser($nip, $id)
    {
        $data = $this
            ->where('nip', $nip)
            ->where('periode_ukom', $id)
            ->where('delete_flag', false)
            ->where('inactive_flag', false)
            ->get();
        if (count($data) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function customSaveWithUpload(array $data, array $file_property)
    {
        DB::transaction(function () use ($data, $file_property) {
            $this->pendaftaran_code = Str::uuid();
            $this->customSave();

            $storageService = new StorageService();
            $storageService->customSaveWithUpload($data, $file_property, $this::bucket_name, 'tbl_ukom', $this->id);
        });
    }

    public function customSave()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->created_by = $userContext->nip ?? '';
            $this->save();
        });
    }

    public function customUpdateWithUpload(array $data)
    {
        DB::transaction(function () use ($data) {
            $this->customUpdate();

            $storageService = new StorageService();
            $storageService->customUpdateWithUpload($data, $this::bucket_name, 'tbl_ukom', $this);
        });
    }

    public function customUpdate()
    {
        DB::transaction(function () {
            $userContext = auth()->user();
            $this->updated_by = $userContext->nip ?? '';
            $this->save();
        });
    }


    public function customDelete()
    {
        DB::transaction(function () {
            $userContext = auth()->user();

            $this->updated_by = $userContext->nip ?? '';
            $this->delete_flag = true;
            $this->save();
        });
    }

    public function hitungHasilAkhirList($ukomList)
    {
        $systemConfiguration = SystemConfiguration::find('rumus_ukom');
        $property = $systemConfiguration->property;

        $result = [];
        foreach ($ukomList as $key => $ukom) {
            $result[] = $this->calculate($ukom, $property);
        }

        return $result;
    }

    public function hitungHasilAkhir($ukom)
    {
        $systemConfiguration = SystemConfiguration::find('rumus_ukom');
        $property = $systemConfiguration->property;

        return $this->calculate($ukom, $property);
    }

    private function calculate($ukom, $property)
    {
        $dataUkom = $ukom->toArray();
        $dataUkom = array_merge($dataUkom, $ukom->ukomMansoskul->toArray());
        $dataUkom = array_merge($dataUkom, $ukom->ukomTeknis->toArray());
        $dataUkom['ukomPeriode'] = $ukom->ukomPeriode;
        $dataUkom['id'] = $ukom->id;

        $nb_cat = 0;
        eval('$nb_cat = ' . $dataUkom["cat"] . $property['nb_cat'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_wawancara = 0;
        eval('$nb_wawancara = ' . $dataUkom["wawancara"] . $property['nb_wawancara'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_seminar = 0;
        eval('$nb_seminar = ' . $dataUkom["seminar"] . $property['nb_seminar'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_praktik = 0;
        eval('$nb_praktik = ' . $dataUkom["praktik"] . $property['nb_praktik'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $total_nilai_ukt = $nb_cat + $nb_wawancara + $nb_seminar + $nb_praktik;
        $nilai_ukt = 0;
        eval('$nilai_ukt = ' . $total_nilai_ukt . $property['nilai_ukt']['value'] . ';');
        $ukmsk = 0;
        eval('$ukmsk = ' . $dataUkom["score"] . $property['ukmsk']['value'] . ';');
        $nilai_akhir = $nilai_ukt + $ukmsk;

        $param_nilai_akhir = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$nilai_akhir']['value'] ?? null;
        $param_total_nilai_ukt = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$total_nilai_ukt']['value'] ?? null;
        $param_jpm = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$jpm']['value'] ?? null;

        $checker = [];
        !empty($param_nilai_akhir) ? eval('$checker[] = ' . "{$nilai_akhir} {$param_nilai_akhir};") : $checker[] = true;
        !empty($param_total_nilai_ukt) ? eval('$checker[] = ' . "{$total_nilai_ukt} {$param_total_nilai_ukt};") : $checker[] = true;
        !empty($param_jpm) ? eval('$checker[] = ' . "{$dataUkom["jpm"]} {$param_jpm};") : $checker[] = true;
        $rekomendasi = 'Lulus Uji Kompetensi';
        $is_lulus = true;
        if (in_array(false, $checker, true)) {
            $rekomendasi = 'Tidak Lulus Uji Kompetensi';
            $is_lulus = false;
        }

        $dataUkom['nb_cat'] = $nb_cat;
        $dataUkom['nb_wawancara'] = $nb_wawancara;
        $dataUkom['nb_seminar'] = $nb_seminar;
        $dataUkom['nb_praktik'] = $nb_praktik;
        $dataUkom['total_nilai_ukt'] = $total_nilai_ukt;
        $dataUkom['nilai_ukt'] = $nilai_ukt;
        $dataUkom['ukmsk'] = $ukmsk;
        $dataUkom['nilai_akhir'] = $nilai_akhir;
        $dataUkom['rekomendasi'] = $rekomendasi;
        $dataUkom['is_lulus'] = $is_lulus;

        return ((object) $dataUkom);
    }

    public function hitungHasilAkhirV2($ukom, $ukomTeknis)
    {
        $systemConfiguration = SystemConfiguration::find('rumus_ukom');
        $property = $systemConfiguration->property;

        return $this->calculateV2($ukom, $ukomTeknis, $property);
    }

    private function calculateV2($ukom, $ukomTeknis, $property)
    {
        $dataUkom = $ukom->toArray();
        $dataUkom = array_merge($dataUkom, $ukom->ukomMansoskul->toArray());
        $dataUkom = array_merge($dataUkom, $ukomTeknis->toArray());

        $nb_cat = 0;
        eval('$nb_cat = ' . $dataUkom["cat"] . $property['nb_cat'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_wawancara = 0;
        eval('$nb_wawancara = ' . $dataUkom["wawancara"] . $property['nb_wawancara'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_seminar = 0;
        eval('$nb_seminar = ' . $dataUkom["seminar"] . $property['nb_seminar'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $nb_praktik = 0;
        eval('$nb_praktik = ' . $dataUkom["praktik"] . $property['nb_praktik'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['value'] . ';');
        $total_nilai_ukt = $nb_cat + $nb_wawancara + $nb_seminar + $nb_praktik;
        $nilai_ukt = 0;
        eval('$nilai_ukt = ' . $total_nilai_ukt . $property['nilai_ukt']['value'] . ';');
        $ukmsk = 0;
        eval('$ukmsk = ' . $dataUkom["score"] . $property['ukmsk']['value'] . ';');
        $nilai_akhir = $nilai_ukt + $ukmsk;

        $param_nilai_akhir = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$nilai_akhir']['value'] ?? null;
        $param_total_nilai_ukt = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$total_nilai_ukt']['value'] ?? null;
        $param_jpm = $property['rekomendasi'][$dataUkom['tujuan_jabatan_code']][$dataUkom['tujuan_jenjang_code']]['$jpm']['value'] ?? null;

        $checker = [];
        !empty($param_nilai_akhir) ? eval('$checker[] = ' . "{$nilai_akhir} {$param_nilai_akhir};") : $checker[] = true;
        !empty($param_total_nilai_ukt) ? eval('$checker[] = ' . "{$total_nilai_ukt} {$param_total_nilai_ukt};") : $checker[] = true;
        !empty($param_jpm) ? eval('$checker[] = ' . "{$dataUkom["jpm"]} {$param_jpm};") : $checker[] = true;
        $rekomendasi = 'Lulus Uji Kompetensi';
        $is_lulus = true;
        if (in_array(false, $checker, true)) {
            $rekomendasi = 'Tidak Lulus Uji Kompetensi';
            $is_lulus = false;
        }

        $dataUkom['nb_cat'] = $nb_cat;
        $dataUkom['nb_wawancara'] = $nb_wawancara;
        $dataUkom['nb_seminar'] = $nb_seminar;
        $dataUkom['nb_praktik'] = $nb_praktik;
        $dataUkom['total_nilai_ukt'] = $total_nilai_ukt;
        $dataUkom['nilai_ukt'] = $nilai_ukt;
        $dataUkom['ukmsk'] = $ukmsk;
        $dataUkom['nilai_akhir'] = $nilai_akhir;
        $dataUkom['rekomendasi'] = $rekomendasi;
        $dataUkom['is_lulus'] = $is_lulus;

        return $dataUkom;
    }
}
