@extends('layout.v_wrapper')
@section('title')
    Ubah Data Kinerja
@endsection
@push('ext_header')
    @include('layout.css_select')
@endpush
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card  ">
                <div class="card-header d-flex bg-body-tertiary">
                </div>
                <div class="card-body p-4">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('/siap/kinerja/update', ['id' => $userPak->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Periode" class="form-label">
                                            Penilaian Tahunan/Periodik
                                        </label>
                                        <select name="periode" class="form-select mb-3" aria-label="Periode" id="Pangkat">
                                            <option @if ($userPak->periode == 1) selected @endif value="1">
                                                Periodik
                                            </option>
                                            <option @if ($userPak->periode == 1) selected @endif value="2">
                                                Tahunan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TanggalMulaiHitungPenilaian" class="form-label">
                                            Tanggal Mulai Hitung Penilaian
                                        </label>
                                        <input name="tgl_mulai" type="date" data-provider="flatpickr"
                                            class="form-control" value="{{ $userPak->tgl_mulai }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TanggalSelesaiHitungPenilaian" class="form-label">
                                            Tanggal Selesai Hitung Penilaian
                                        </label>
                                        <input name="tgl_selesai" type="date" data-provider="flatpickr"
                                            class="form-control" id="TanggalSelesaiHitungPenilaian"
                                            value="{{ $userPak->tgl_selesai }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="NilaiKinerja" class="form-label">
                                            Rating Hasil Kinerja
                                        </label>
                                        <select name="nilai_kinerja" class="form-select mb-3" aria-label="Periode"
                                            id="Pangkat">
                                            <option @if ($userPak->nilai_kinerja == 'Di Atas Ekspektasi') selected @endif
                                                value="Di Atas Ekspektasi">
                                                Di Atas Ekspektasi
                                            </option>
                                            <option @if ($userPak->nilai_kinerja == 'Sesuai Ekspektasi') selected @endif
                                                value="Sesuai Ekspektasi">
                                                Sesuai Ekspektasi
                                            </option>
                                            <option @if ($userPak->nilai_kinerja == 'Di Bawah Ekspektasi') selected @endif
                                                value="Di Bawah Ekspektasi">
                                                Di Bawah Ekspektasi
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="NilaiPerilaku" class="form-label">
                                            Rating Perilaku Kerja
                                        </label>
                                        <select name="nilai_perilaku" class="form-select mb-3" aria-label="Periode"
                                            id="Pangkat">
                                            <option @if ($userPak->nilai_perilaku == 'Di Atas Ekspektasi') selected @endif
                                                value="Di Atas Ekspektasi">
                                                Di Atas Ekspektasi
                                            </option>
                                            <option @if ($userPak->nilai_perilaku == 'Sesuai Ekspektasi') selected @endif
                                                value="Sesuai Ekspektasi">
                                                Sesuai Ekspektasi
                                            </option>
                                            <option @if ($userPak->nilai_perilaku == 'Di Bawah Ekspektasi') selected @endif
                                                value="Di Bawah Ekspektasi">
                                                Di Bawah Ekspektasi
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="RatingPredikat" class="form-label">
                                            Predikat Kinerja
                                        </label>
                                        <select name="predikat" class="form-select mb-3" aria-label="RatingPredikat"
                                            id="Pangkat">
                                            <option @if ($userPak->predikat == 'Sangat baik') selected @endif value="Sangat baik">
                                                Sangat baik
                                            </option>
                                            <option @if ($userPak->predikat == 'Baik') selected @endif value="Baik">
                                                Baik
                                            </option>
                                            <option @if ($userPak->predikat == 'Butuh Perbaikan') selected @endif
                                                value="Butuh Perbaikan">
                                                Butuh Perbaikan
                                            </option>
                                            <option @if ($userPak->predikat == 'Kurang') selected @endif value="Kurang">
                                                Kurang
                                            </option>
                                            <option @if ($userPak->predikat == 'Sangat kurang') selected @endif
                                                value="Sangat kurang">
                                                Sangat kurang
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="AngkaKredit" class="form-label">
                                            Angka Kredit
                                        </label>
                                        <input name="angka_kredit" type="number" class="form-control" id="AngkaKredit"
                                            placeholder="Masukkan Angka Kredit" value="{{ $userPak->angka_kredit }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="HasilEvaluasiKinerja" class="form-label">
                                            Dokumen Hasil Evaluasi Kinerja
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_hasil_eval"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPak->file_hasil_eval) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_hasil_eval" type="file" accept=".pdf" class="form-control"
                                            id="HasilEvaluasiKinerja" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="KonversiPredikatKinerja" class="form-label">
                                            Dokumen Konversi Predikat Kinerja
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_dok_konversi"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPak->file_dok_konversi) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_dok_konversi" type="file" accept=".pdf"
                                            class="form-control" id="KonversiPredikatKinerja" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="AkumulasiAngkaKredit" class="form-label">
                                            Dokumen Akumulasi Angka Kredit
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_akumulasi_ak"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPak->file_akumulasi_ak) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_akumulasi_ak" type="file" accept=".pdf"
                                            class="form-control" id="AkumulasiAngkaKredit" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="DokumenAngkaKredit" class="form-label">
                                            Dokumen Penetapan Angka Kredit
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_doc_ak"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPak->file_doc_ak) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_doc_ak" type="file" accept=".pdf" class="form-control"
                                            id="DokumenAngkaKredit" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-info">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('widget.modal-doc')
@endsection
