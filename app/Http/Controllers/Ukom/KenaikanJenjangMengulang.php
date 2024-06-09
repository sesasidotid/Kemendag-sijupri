<?php

namespace App\Http\Controllers\Ukom;
use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ukom\Service\UkomJadwalService;
use App\Http\Controllers\Ukom\Service\UkomRiwayatService;
use App\Http\Controllers\Ukom\Service\UkomService;
use App\Http\Controllers\Security\Service\UserService;
use App\Http\Controllers\Service\PengumumanService;
use App\Http\Controllers\Siap\Service\UserPakService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use App\Models\Ukom\UkomJadwal;

class KenaikanJenjangMengulang extends Controller
{
    public $periodeUkom;
    public $userUkom;
    public function __construct()
    {
        $this->periodeUkom = $this->cekPeriode();
    }

    public function cekPeriode()
    {
        $periode = new UkomPeriodeService();
        $periode = $periode->cekPeriode(TaskStatus::APPROVE);
        return $periode;
    }
    public function kenaikanAdminJenjangMengulangDetail($id)
    {

        $periode = $this->periodeUkom ;
        $ukomJadwal = new UkomJadwalService();
        $ukom = new UkomService();
        $ukomRiwayat = new UkomRiwayatService();
        $jadwal = new UkomJadwal();
        $jadwalList = $ukomJadwal->findAll();
        $data = $ukom->findById($id);
        $user = new UserService();
        $user = $user->findById($data->nip);
        $pak = new UserPakService();
        $unitKerja = $user->unitKerja;
        $pak = $pak->findByNip($data->nip);
        $pendidikan = $user->userPendidikan ;
        $kompetensi = $user->userKompetensi ;
        $jenjangTerakhir = $user->userDetail->jabatan->jenjang->name ;

        session()->put('nip', $data->nip);
        return view('ukom.admin.kenaikanjenjang.mengulang.verifikasi.index', compact(
            'data',
            'jadwalList',
            'pak',
            'user',
            'unitKerja',
            'pendidikan',
            'kompetensi',
            'periode',
            'jenjangTerakhir'
        ));

    }
}