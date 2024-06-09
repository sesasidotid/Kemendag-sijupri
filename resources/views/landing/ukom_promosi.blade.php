@extends('layout.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    @include('layout.css_select')
@endsection
@section('content')
    <nav class="navbar navbar-expand-lg navbar-landing fixed-top bg-white" id="navbar">
        <div class="container">
            <a href="#" class="logo logo-dark ">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320-bg.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768-bg.png') }}" alt="" height="40">
                </span>
            </a>
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('images/kemendag-320.png') }}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('images/kemendag-768.png') }}" alt="" height="40">
                </span>
            </a>
            <button class="navbar-toggler py-0 fs-20 text-body" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="w-100">
                    <ul class="navbar-nav mt-2 mt-lg-0 float-end" id="navbar-example">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('/') }}">Landing</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-soft-primary mt-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="vertical-overlay" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent.show"></div>
    <section class="section pb-5 hero-section mt-5" id="hero">
        <div class="bg-overlay bg-overlay-pattern"></div>
        <div class="card container">
            <div class="card-header">
                <div class="text-center w-100">
                    @if ($ukomPeriode)
                        <h3 class="mb-3 fw-semibold mb-5">
                            Pendaftaran UKom Periode
                            {{ \Carbon\Carbon::parse($ukomPeriode->periode)->locale('id')->translatedFormat('F Y') }}
                        </h3>
                    @else
                        <h3 class="mb-3 fw-semibold mb-5">
                            Pendaftaran UKom Sedang Tutup
                        </h3>
                    @endif
                </div>
            </div>
            @if ($ukomPeriode)
                <div class="card-body">
                    @if (!$email)
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for=""><span class="text-danger fw-bold">*</span>Jenis UKom</label>
                                    <select id="jenis_ukom" class="js-example-basic-single form-control" name="jenis_ukom">
                                        <option value="promosi" @if (!old('jenis_ukom')) selected @endif>
                                            Promosi
                                        </option>
                                        <option value="perpindahan" @if ('perpindahan' == old('jenis_ukom')) selected @endif>
                                            Perpindahan Jabatan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for=""><span class="text-danger fw-bold">*</span>
                                        Status Pendaftaran
                                    </label>
                                    <select class="js-example-basic-single form-control" name="type">
                                        <option @if (!old('type')) selected @endif value="baru">Baru
                                        </option>
                                        <option @if ('type' == old('type')) selected @endif value="mengulang">
                                            Mengulang
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <span class="text-danger fw-bold">*</span>Email <span class="text-info">(sesuai dengan email yang terdaftar pada KUDAGANG)</span>
                                        </label>
                                        <input type="text" class="form-control" id="email" name="email"
                                            value="{{ old('email') ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mt-3 pt-3">
                                        <button type="submit" class="btn btn-md btn-primary">Kirim</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12">
                            <hr class="bg-primary" style="border: none; height: 5px;">
                        </div>
                    @else
                        <form method="POST"
                            action="{{ route('/page/ukom/daftar', [
                                'ukom_periode_id' => $ukomPeriode->id,
                                'tipe_user' => $tipe_user,
                                'jenis_ukom' => $jenis_ukom,
                                'type' => $type,
                                'email' => $email,
                                'nip' => $ukom->nip ?? null,
                                'name' => $ukom->name ?? null,
                                'tempat_lahir' => $ukom->detail->tempat_lahir ?? null,
                                'tanggal_lahir' => $ukom->detail->tanggal_lahir ?? null,
                                'jenis_kelamin' => $ukom->detail->jenis_kelamin ?? null,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">
                                            <span class="text-danger fw-bold">*</span>NIP
                                        </label>
                                        <input type="number" class="form-control" {{ $ukom ? 'disabled' : '' }}
                                            id="nip" name="nip" oninput="limitLength(this, 18)"
                                            value="{{ $ukom->nip ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama
                                        </label>
                                        <input type="text" {{ $ukom ? 'disabled' : '' }} class="form-control"
                                            id="name" name="name" value="{{ $ukom->name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tempat Lahir
                                        </label>
                                        <input type="text" {{ $ukom ? 'disabled' : '' }} class="form-control"
                                            id="tempat_lahir" name="tempat_lahir"
                                            value="{{ $ukom->detail->tempat_lahir ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Tanggal Lahir
                                        </label>
                                        <input type="date" {{ $ukom ? 'disabled' : '' }} class="form-control"
                                            data-provider="flatpickr" id="tanggal_lahir" name="tanggal_lahir"
                                            value="{{ $ukom->detail->tanggal_lahir ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Email
                                        </label>
                                        <input type="email" disabled class="form-control" data-provider="flatpickr"
                                            id="email" name="email" value="{{ $email ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jenis Kelamin
                                        </label>
                                        @if ($ukom)
                                            <input type="text" disabled class="form-control" data-provider="flatpickr"
                                                id="jenis_kelamin" name="jenis_kelamin"
                                                value="{{ $ukom->detail->jenis_kelamin ?? '' }}">
                                        @else
                                            <select class="js-example-basic-single" name="jenis_kelamin"
                                                id="jenis_kelamin">
                                                <option @if (!old('jenis_kelamin')) selected @endif value="">
                                                    Pilih Jenis Kelamin
                                                </option>
                                                <option @if (old('jenis_kelamin') == 'Pria') selected @endif value="Pria">
                                                    Pria
                                                </option>
                                                <option @if (old('jenis_kelamin') == 'Wanita') selected @endif value="Wanita">
                                                    Wanita
                                                </option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Pendidikan Terakhir
                                        </label>
                                        <select class="js-example-basic-single" name="pendidikan" id="pendidikan">
                                            <option selected value="">
                                                Pilih Pendidikan Terakhir
                                            </option>
                                            <option @if (old('pendidikan') ?? ($ukom->detail->pendidikan ?? '') == 'SMA') selected @endif value="SMA">SMA
                                            </option>
                                            <option @if (old('pendidikan') ?? ($ukom->detail->pendidikan ?? '') == 'D3') selected @endif value="D3">D3
                                            </option>
                                            <option @if (old('pendidikan') ?? ($ukom->detail->pendidikan ?? '') == 'D4/S1') selected @endif value="D4/S1">
                                                D4/S1
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Program Studi
                                        </label>
                                        <input type="text" class="form-control" id="jurusan" name="jurusan"
                                            value="{{ $ukom->detail->jurusan ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr class="bg-primary" style="border: none; height: 5px;">
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Unit Kerja/Instansi Daerah
                                        </label>
                                        <select class="js-example-basic-single form-control" name="unit_kerja_id">
                                            <option selected value="">
                                                Pilih Unit Kerja/Instansi Daerah
                                            </option>
                                            @if (isset($unitKerjaList))
                                                @foreach ($unitKerjaList as $index => $unitKerja)
                                                    <option @if (old('unit_kerja_id') ?? ($ukom->unit_kerja_id ?? '') == $unitKerja->id) selected @endif
                                                        value="{{ $unitKerja->id }}">
                                                        {{ $unitKerja->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="karpeg" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nomor Kartu Pegawai
                                        </label>
                                        <input type="text" class="form-control" id="karpeg" name="karpeg"
                                            maxlength="10" oninput="validateLength(this)"
                                            value="{{ $ukom->detail->karpeg ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_cpns" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMT CPNS
                                        </label>
                                        <input type="date" class="form-control" data-provider="flatpickr"
                                            id="tmt_cpns" name="tmt_cpns" value="{{ $ukom->detail->tmt_cpns ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jabatan_name" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jabatan
                                        </label>
                                        <input type="text" class="form-control" id="jabatan_name" name="jabatan_name"
                                            value="{{ $ukom->detail->jabatan_name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_jabatan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMT Jabatan
                                        </label>
                                        <input type="date" class="form-control" data-provider="flatpickr"
                                            id="tmt_jabatan" name="tmt_jabatan"
                                            value="{{ $ukom->detail->tmt_jabatan ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Tujuan Jabatan
                                        </label>
                                        <select class="js-example-basic-single form-control" name="tujuan_jabatan_code">
                                            <option selected value="">
                                                Pilih Jabatan
                                            </option>
                                            @if (isset($jabatanList))
                                                @foreach ($jabatanList as $index => $jabatan)
                                                    <option @if (old('tujuan_jabatan_code') ?? ($ukom->tujuan_jabatan_code ?? '') == $jabatan->code) selected @endif
                                                        value="{{ $jabatan->code }}">
                                                        {{ $jabatan->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Pangkat
                                        </label>
                                        <select class="js-example-basic-single form-control" name="pangkat_id">
                                            <option selected value="">
                                                Pilih Pangkat
                                            </option>
                                            @if (isset($pangkatList))
                                                @foreach ($pangkatList as $index => $pangkat)
                                                    <option @if (old('pangkat_id') ?? ($ukom->pangkat_id ?? '') == $pangkat->id) selected @endif
                                                        value="{{ $pangkat->id }}">
                                                        {{ $pangkat->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_pangkat" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMT Pangkat
                                        </label>
                                        <input type="date" class="form-control" data-provider="flatpickr"
                                            id="tmt_pangkat" name="tmt_pangkat"
                                            value="{{ $ukom->detail->tmt_pangkat ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr class="bg-primary" style="border: none; height: 5px;">
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="angka_kredit" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Angkat Kredit
                                        </label>
                                        <input type="numeric" class="form-control" id="angka_kredit" name="angka_kredit"
                                            value="{{ $ukom->angka_kredit ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr class="bg-primary" style="border: none; height: 5px;">
                                </div>
                                {{-- ------------------------------ --}}
                                <dynamic id="dokumen-persyaratan"></dynamic>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success float-end">
                                    Ajukan <i class=" las la-save"></i>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif
            @include('widget.modal-doc')
        </div>
    </section>
@endsection
@section('script')
    @include('layout.js_select')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/landing.init.js') }}"></script>
    <script>
        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        },
        function validateLength(input) {
            if (input.value.length > 10) {
                input.value = input.value.slice(0, 10);
            }
        }
    </script>
    <script>
        function fileElm(fileName) {
            return `<div  class="col-md-12 mb-3">
                <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                    ${fileName}
                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                </label>
                <input type="file" accept=".pdf" class="form-control"
                    name="${fileName.replace(' ', '_').toLowerCase()}" id="employeeName">
            </div>`;
        }

        $(document).ready(function() {
            var container = $('#dokumen-persyaratan');
            var dokumen = @json($filePersyaratan);
            $.each(dokumen.values, function(key, value) {
                container.append(fileElm(value));
            });
        });
    </script>
@endsection
