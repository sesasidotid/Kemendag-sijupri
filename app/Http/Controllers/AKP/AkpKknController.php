<?php

namespace App\Http\Controllers\AKP;

use App\Http\Controllers\AKP\Service\AkpInstrumenService;
use App\Http\Controllers\AKP\Service\AkpKategoriPertanyaanService;
use App\Http\Controllers\AKP\Service\AkpPertanyaanService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AkpKknController extends Controller
{

    public function index(Request $request)
    {
        $akpInstrument = new AkpInstrumenService();
        $akpKategoriPertanyaan = new AkpKategoriPertanyaanService();
        $data = $request->all();
        $data['attr']['delete_flag'] = false;
        $data['cond']['delete_flag'] = '=';
        $data['cond']['akp_instrumen_id'] = '=';

        $akpInstrumentList = $akpInstrument->findAll();
        $akpKategoriPertanyaanList = $akpKategoriPertanyaan->findSearchPaginate($data);
        return view('akp.admin.kkn.index', compact(
            'akpInstrumentList',
            'akpKategoriPertanyaanList'
        ));
    }

    public function detail(Request $request)
    {
        $akpInstrument = new AkpInstrumenService();
        $akpKategoriPertanyaan = new AkpKategoriPertanyaanService();

        $akpInstrumentList = $akpInstrument->findAll();
        $akpKategoriPertanyaan = $akpKategoriPertanyaan->findById($request->id);
        return view('akp.admin.kkn.detail', compact(
            'akpInstrumentList',
            'akpKategoriPertanyaan'
        ));
    }

    public function pertanyaan(Request $request)
    {
        $kategoriInstrumen = new AkpKategoriPertanyaanService();
        $akpPertanyaan = new AkpPertanyaanService();
        $akp_kategori_pertanyaan_id = $request->akp_kategori_pertanyaan_id;
        $data = $request->all();
        $data['attr']['akp_kategori_pertanyaan_id'] = $akp_kategori_pertanyaan_id;
        $data['cond']['akp_kategori_pertanyaan_id'] = '=';

        $akpKategorPertanyaantList = $kategoriInstrumen->findById($akp_kategori_pertanyaan_id);
        $akpPertanyaanList = $akpPertanyaan->findSearchPaginate($data);
        return view('akp.admin.kkn.pertanyaan', compact(
            'akp_kategori_pertanyaan_id',
            'akpKategorPertanyaantList',
            'akpPertanyaanList'
        ));
    }

    public function pertanyaanDetail(Request $request)
    {
        $kategoriInstrumen = new AkpKategoriPertanyaanService();
        $akpPertanyaan = new AkpPertanyaanService();
        $akpPertanyaan = $akpPertanyaan->findById($request->id);

        return view('akp.admin.kkn.pertanyaan_detail', compact(
            'akpPertanyaan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'akp_instrumen_id' => 'required',
            'kategori' => 'required',
        ]);

        $akpKategoriPertanyaan = new AkpKategoriPertanyaanService();
        $akpKategoriPertanyaan->fill($request->all());
        $akpKategoriPertanyaan->customSave();

        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $request->validate([
            'akp_instrumen_id' => 'required',
            'kategori' => 'required',
        ]);

        $akpKategoriPertanyaan = new AkpKategoriPertanyaanService();
        $akpKategoriPertanyaan = $akpKategoriPertanyaan->findById($request->id);
        $akpKategoriPertanyaan->fill($request->all());
        $akpKategoriPertanyaan->customUpdate();

        return redirect()->route('/akp/kkn');
    }

    public function delete(Request $request)
    {
        $akpKategoriPertanyaan = new AkpKategoriPertanyaanService();
        $akpKategoriPertanyaan = $akpKategoriPertanyaan->findById($request->id);
        $akpKategoriPertanyaan->customDelete();

        return redirect()->back();
    }

    public function pertanyaanStore(Request $request)
    {
        $request->validate([
            'akp_kategori_pertanyaan_id' => 'required',
            'pertanyaan' => 'required',
        ]);

        $akpPertanyaan = new AkpPertanyaanService();
        $akpPertanyaan->fill($request->all());
        $akpPertanyaan->customSave();

        return redirect()->back();
    }

    public function pertanyaanEdit(Request $request)
    {
        $request->validate(['pertanyaan' => 'required']);

        $akpPertanyaan = new AkpPertanyaanService();
        $akpPertanyaan = $akpPertanyaan->findById($request->id);

        $akpPertanyaan->fill($request->all());
        $akpPertanyaan->customUpdate();

        return redirect()->route('/akp/kkn/pertanyaan', ['akp_kategori_pertanyaan_id' => $akpPertanyaan->akp_kategori_pertanyaan_id]);
    }

    public function pertanyaanDelete(Request $request)
    {
        $akpPertanyaan = new AkpPertanyaanService();
        $akpPertanyaan = $akpPertanyaan->findById($request->id);
        $akpPertanyaan->customDelete();

        return redirect()->back();
    }
}
