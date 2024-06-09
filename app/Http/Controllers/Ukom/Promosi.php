<?php

namespace App\Http\Controllers\Ukom;

use App\Enums\TaskStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Ukom\Service\UkomService;
use App\Http\Controllers\Maintenance\Service\JenjangService;
use App\Http\Controllers\Ukom\Service\UkomPeriodeService;
use Illuminate\Http\Request;

class Promosi extends Controller
{   public $periodeUkom;
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
    public function cekUser()
    {
        $nip = auth()->user()->nip;

        if(isset($periode)){

            return null ;
        }else{
            $periode = $this->periodeUkom->id;
            $userUkom = new UkomService();
            return    $userUkom = $userUkom->cekUser($nip, $periode);
        }

    }
    public function promosiBaru(){
        $periode = $this->periodeUkom;
        $userContext = auth()->user();
        $jabatan = new JenjangService();
        $aktif = $userContext->user_status;
        $jenjangTerakhir = $userContext->jabatan->jenjang;
        $ukom = new UkomService();
        $ukom = $ukom->findByNip($userContext->nip);
        $userUkom = $this->cekUser();
        $jabatan = new JenjangService() ;
        $jabatan = $jabatan->findAll();

        if (isset($ukom->ukomJadwal)) {
            $ukom = $ukom->ukomJadwal;
        } else {
            $ukom = '';
        }

        return view('ukom.promosi.baru', compact('jabatan', 'aktif', 'jenjangTerakhir', 'ukom', 'periode', 'userUkom')) ;
    }
    public function promosiMengulang(){
        $periode = $this->periodeUkom;
        $userContext = auth()->user();
        $jabatan = new JenjangService();
        $aktif = $userContext->user_status;
        $jenjangTerakhir = $userContext->jabatan->jenjang;
        $ukom = new UkomService();
        $ukom = $ukom->findByNip($userContext->nip);
        $userUkom = $this->cekUser();
        $jabatan = new JenjangService() ;
        $jabatan = $jabatan->findAll();

        if (isset($ukom->ukomJadwal)) {
            $ukom = $ukom->ukomJadwal;
        } else {
            $ukom = '';
        }

        return view('ukom.promosi.mengulang', compact('jabatan', 'aktif', 'jenjangTerakhir', 'ukom', 'periode', 'userUkom')) ;
    }
    public function promosiBaruStore(Request $request){
        $ukom = new UkomService();
        $userContext = auth()->user();
        $jabatan = new JenjangService();
        $jabatanData = $jabatan->findNextJabatan($userContext->jabatan->jenjang->urutan);
        $ukom->fill($request->all());
        $ukom->periode_ukom= $this->periodeUkom->id ;
        $ukom->nip = $userContext->nip;
        $ukom->customSaveWithUpload($request->all());
        return redirect('/ukom/promosi/baru') ;
    }
    public function promosiMengulangStore(Request $request){
        $ukom = new UkomService();
        $userContext = auth()->user();
        $jabatan = new JenjangService();
        $jabatanData = $jabatan->findNextJabatan($userContext->jabatan->jenjang->urutan);
        $ukom->fill($request->all());
        $ukom->periode_ukom= $this->periodeUkom->id ;
        $ukom->nip = $userContext->nip;
        $ukom->customSaveWithUpload($request->all());
        return redirect('/ukom/promosi/mengulang') ;
    }
    public function promosiBaruAdmin(){
        $ukom = new UkomService();
        if (isset($this->periodeUkom->id)) {
            $ukomList = $ukom->findAllPeriodeBaru($this->periodeUkom->id ,'promosi');
            $list = $ukom->findAllPendingBaru($this->periodeUkom->id,'promosi');
            $list2 = $ukom->findAllDiterimaBaru($this->periodeUkom->id,'promosi');
            $periode = $this->periodeUkom;
            $status = 1;
            return view('ukom.admin.promosi.baru.index', compact('list', 'list2', 'ukomList', 'periode', 'status'));
        } else {
            $status = 0;
            return view('ukom.admin.promosi.baru.index', compact('status'));
        }
    }
    public function promosiAdminJenjangPending()
    {
        $ukom = new UkomService();

        $list = $ukom->findAllPendingBaru($this->periodeUkom->id, 'promosi');

        return view('ukom.admin.promosi.baru.pending', compact('list'));
    }
    public function promosiAdminJenjangDiterima()
    {
        $ukom = new UkomService();
        $ukomList = $ukom->findAll();
        $list = $ukom->findAllPendingBaru($this->periodeUkom->id,'promosi');
        $list2 = $ukom->findAllDiterimaBaru($this->periodeUkom->id,'promosi');
        return view('ukom.admin.promosi.baru.diterima', compact('list', 'list2', 'ukomList'));
    }
    public function promosiAdminJenjangDitolak()
    {
        $ukom = new UkomService();
        $ukomList = $ukom->findAll();
        $list2 = $ukom->findAllDitolak($this->periodeUkom->id,'promosi');

        return view('ukom.admin.promosi.baru.ditolak', compact('list2'));
    }
    public function promosiAdminJenjangMengulangIndex(){
        $ukom = new UkomService();
        if (isset($this->periodeUkom->id)) {
            $ukomList = $ukom->findAllPeriodeMengulang($this->periodeUkom->id,'promosi');
            $list = $ukom->findAllPendingMengulang($this->periodeUkom->id ,'promosi');
            $list2 = $ukom->findAllDiterimaBaru($this->periodeUkom->id,'promosi');

            $periode = $this->periodeUkom;
            $status = 1;
            return view('ukom.admin.promosi.mengulang.index', compact('list', 'list2', 'ukomList', 'periode', 'status'));
        } else {
            $status = 0;
            return view('ukom.admin.promosi.mengulang.index', compact('status'));
        }
    }
    public function promosiAdminJenjangPendingMengulang(){
        $ukom = new UkomService();

        $list = $ukom->findAllPendingMengulang($this->periodeUkom->id,'promosi');
        return view('ukom.admin.promosi.mengulang.pending', compact('list'));
    }
    public function promosiAdminJenjangDiterimaMengulang(){
        $ukom = new UkomService();
        $ukomList = $ukom->findAll();
        $list = $ukom->findAllPendingBaru($this->periodeUkom->id,'promosi');
        $list2 = $ukom->findAllDiterimaMengulang($this->periodeUkom->id ,'promosi');
        return view('ukom.admin.promosi.mengulang.diterima', compact('list', 'list2', 'ukomList'));

    }
    public function promosiAdminJenjangDitolakMengulang(){
        $ukom = new UkomService();
        $ukomList = $ukom->findAll();
        $list2 = $ukom->findAllDitolakMengulang($this->periodeUkom->id ,'promosi');

        return view('ukom.admin.promosi.mengulang.ditolak', compact('list2'));
    }
    public function sanggahBaru()
    {
        $periode = $this->periodeUkom;
        $userContext = auth()->user();
        $jabatan = new JenjangService();
        $aktif = $userContext->user_status;
        $jenjangTerakhir = $userContext->jabatan->jenjang;
        $ukom = new UkomService();
        $ukom = $ukom->findByNip($userContext->nip);
        if($this->cekUser()==null){
            $userUkom='' ;
        }else{
            $userUkom = $this->cekUser();
        }

        $jabatan = $jabatan->findAll();
          return view('ukom.promosi.sanggahBaru', compact('jabatan', 'aktif', 'jenjangTerakhir', 'ukom', 'periode', 'userUkom'));
    }
    public function sanggahBaruStore(Request $request)
    {

        $ukom = new UkomService();
        $ukom = $ukom->findById($request->id_ukom);
        $ukom->fill($request->all());
        $ukom->sanggah = 1;
        $ukom->customUpdateWithUpload($request->all());
    }
    public function promosiSanggah(){
        $ukom = new UkomService();
        $list2 = $ukom->findAllPendingSanggah($this->periodeUkom->id,'promosi');
        return view('ukom.admin.promosi.baru.sanggah', compact('list2'));
    }
    public function promosiSanggahMengulang(){
        $ukom = new UkomService();
        $list2 = $ukom->findAllPendingSanggahMengulang($this->periodeUkom->id,'promosi');
        return view('ukom.admin.promosi.baru.sanggah', compact('list2'));
    }

}
