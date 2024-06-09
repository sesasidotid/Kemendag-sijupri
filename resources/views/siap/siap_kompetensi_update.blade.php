@extends('layout.v_wrapper')
@section('title')
    Ubah Data Kompetensi
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
                        <form method="POST" action="{{ route('/siap/kompetensi/update', ['id' => $userKompetensi->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="NamaKompetensi" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama Kompetensi
                                        </label>
                                        <input name="name" class="form-control" placeholder="Nama Kompetensi"
                                            value="{{ $userKompetensi->name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="KategoriKompetensi" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Kategori Pengembangan
                                        </label>
                                        <select name="kategori" class="form-select mb-3" aria-label="KategoriKompetensi"
                                            id="KategoriKompetensi">
                                            <option @if ($userKompetensi->kategori == 'Pelatihan Fungsional') selected @endif
                                                value="Pelatihan Fungsional">
                                                Pelatihan Fungsional
                                            </option>
                                            <option @if ($userKompetensi->kategori == 'Pelatihan Teknis') selected @endif
                                                value="Pelatihan Teknis">
                                                Pelatihan Teknis
                                            </option>
                                            <option @if ($userKompetensi->kategori == 'Coaching/Mentoring') selected @endif
                                                value="Coaching/Mentoring">
                                                Coaching/Mentoring
                                            </option>
                                            <option @if ($userKompetensi->kategori == 'Penugasan') selected @endif value="Penugasan">
                                                Penugasan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TanggalMulai" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tanggal Mulai
                                        </label>
                                        <input name="tgl_mulai" type="date" data-provider="flatpickr"
                                            class="form-control" id="TanggalMulai" value="{{ $userKompetensi->tgl_mulai }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TanggalSelesai" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tanggal Selesai
                                        </label>
                                        <input name="tgl_selesai" type="date" data-provider="flatpickr"
                                            class="form-control" id="TanggalSelesai"
                                            value="{{ $userKompetensi->tgl_selesai }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="TanggalSertifikat" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tanggal Sertifikat
                                        </label>
                                        <input name="tgl_sertifikat" type="date" data-provider="flatpickr"
                                            class="form-control" id="TanggalSertifikat"
                                            value="{{ $userKompetensi->tgl_sertifikat }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="FileSertifikat" class="form-label">
                                            <span class="text-danger fw-bold">*</span> File Serifikat
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_sertifikat"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userKompetensi->file_sertifikat) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_sertifikat" type="file" accept=".pdf" class="form-control"
                                            id="FileSertifikat" />
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
