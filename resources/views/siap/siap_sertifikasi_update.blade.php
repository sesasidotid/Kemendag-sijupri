@extends('layout.v_wrapper')
@section('title')
    Ubah Data Sertifikasi
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
                        <form method="POST" action="{{ route('/siap/sertifikasi/update', ['id' => $userSertifikasi->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="Kategori" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Kategori Sertifikasi
                                        </label>
                                        <select name="kategori" class="form-select mb-3" aria-label="Kategori"
                                            id="Kategori">
                                            <option @if ($userSertifikasi->kategori == 'Pegawai Berhak') selected @endif
                                                value="Pegawai Berhak">
                                                Pegawai Berhak
                                            </option>
                                            <option @if ($userSertifikasi->kategori == 'Penyidik Pegawai Negri Sipil(PPNS)') selected @endif
                                                value="Penyidik Pegawai Negri Sipil(PPNS)">
                                                Penyidik Pegawai Negri Sipil
                                                (PPNS)
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="NoSK" class="form-label">
                                            <span class="text-danger fw-bold">*</span> No. SK
                                        </label>
                                        <input name="nomor_sk" type="text" class="form-control" id="NoSK"
                                            placeholder="Masukkan No. SK" value="{{ $userSertifikasi->nomor_sk }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TanggalSK" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tanggal SK
                                        </label>
                                        <input name="tanggal_sk" type="date" data-provider="flatpickr"
                                            class="form-control" id="TanggalSK" value="{{ $userSertifikasi->tanggal_sk }}">
                                    </div>
                                </div>
                                @if (isset($request['kategori']) && $request['kategori'] != null && $request['kategori'] != 'Pegawai Berhak')
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="WilayahKerja" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Wilayah Kerja
                                            </label>
                                            <input name="wilayah_kerja" type="text" class="form-control"
                                                id="WilayahKerja" placeholder="Masukkan Penugasan"
                                                value="{{ $userSertifikasi->wilayah_kerja }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="TglMulai" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Tanggal Berlaku Mulai
                                            </label>
                                            <input name="berlaku_mulai" type="date" data-provider="flatpickr"
                                                class="form-control" id="TglMulai"
                                                value="{{ $userSertifikasi->berlaku_mulai }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="TglSampai" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Tanggal Berlaku Sampai
                                            </label>
                                            <input name="berlaku_sampai" type="date" data-provider="flatpickr"
                                                class="form-control" id="TglSampai"
                                                value="{{ $userSertifikasi->berlaku_sampai }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="UUKawalan" class="form-label">
                                                <span class="text-danger fw-bold">*</span> UU yang di Kawal
                                            </label>
                                            <input name="uu_kawalan" type="text" class="form-control" id="UUKawalan"
                                                value="{{ $userSertifikasi->uu_kawalan }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="SKPengangkatan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Dokumen SK Pengangkatan
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_doc_sk"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userSertifikasi->file_doc_sk) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_doc_sk" type="file" accept=".pdf" class="form-control"
                                            id="SKPengangkatan" placeholder="Masukkan Penugasan">
                                    </div>
                                </div>
                                @if (isset($request['kategori']) && $request['kategori'] != null && $request['kategori'] != 'Pegawai Berhak')
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="TKPPPNS" class="form-label">
                                                <span class="text-danger fw-bold">*</span> Kartu Tanda Pengenal PPNS
                                                <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                            </label>
                                            <a class="btn btn-sm btn-soft-info" name="preview-button-file_ktp_ppns"
                                                href="javascript:void(0);"
                                                onclick="previewModal({{ json_encode($userSertifikasi->file_ktp_ppns) }}, 'Ijazah')">
                                                Lihat
                                            </a>
                                            <input name="file_ktp_ppns" type="file" accept=".pdf"
                                                class="form-control" id="TKPPPNS" placeholder="Masukkan Penugasan">
                                        </div>
                                    </div>
                                @endif
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
