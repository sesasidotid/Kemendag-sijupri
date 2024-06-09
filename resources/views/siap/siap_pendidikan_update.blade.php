@extends('layout.v_wrapper')
@section('title')
    Ubah Data Pendidikan
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
                        <form method="POST" action="{{ route('/siap/pendidikan/update', ['id' => $userPendidikan->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Pendidikan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tingkat Pendidikan
                                        </label>
                                        <select name="level" class="form-select mb-3" aria-label="Pendidikan"
                                            id="Pendidikan">
                                            <option @if ($userPendidikan->level == 'SMA') selected @endif value="SMA">
                                                SLTA/SMK
                                            </option>
                                            <option @if ($userPendidikan->level == 'D3') selected @endif value="D3">
                                                D3
                                            </option>
                                            <option @if ($userPendidikan->level == 'S1') selected @endif value="S1">
                                                S1/D4
                                            </option>
                                            <option @if ($userPendidikan->level == 'S2') selected @endif value="S2">
                                                S2
                                            </option>
                                            <option @if ($userPendidikan->level == 'S3') selected @endif value="S3">
                                                S3
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="InstansiPendidikan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama Institusi Pendidikan
                                        </label>
                                        <input name="instansi_pendidikan" type="text" class="form-control"
                                            id="InstansiPendidikan" placeholder="Masukkan Nama Institusi Pendidikan"
                                            value="{{ $userPendidikan->instansi_pendidikan }}">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="Jurusan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jurusan/Program Studi
                                        </label>
                                        <input name="jurusan" type="text" class="form-control" id="Jurusan"
                                            placeholder="Masukkan Jurusan/Program Studi"
                                            value="{{ $userPendidikan->jurusan }}">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="InstansiPendidikan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tingkat Pendidikan Tanggal Ijazah
                                        </label>
                                        <input name="bulan_kelulusan" type="date" data-provider="flatpickr"
                                            class="form-control" id="InstansiPendidikan"
                                            value="{{ $userPendidikan->bulan_kelulusan }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="FileIjazah" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tingkat Pendidikan File Ijazah
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_ijazah"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPendidikan->file_ijazah) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_ijazah" type="file" accept=".pdf"
                                            class="form-control  border-bottom-1" id="FileIjazah" />
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
