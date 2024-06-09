@extends('layout.master-without-nav')
@section('title')
    Landing
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    @include('layout.css_select')
@endsection
@section('content')
    <div class="layout-wrapper landing">
        <section class="section bg-light" id="ukom">
            <div class="bg-overlay bg-overlay-pattern"></div>
            <div class="container">
                <div class="card card-body">
                    <div class="text-center mb-5">
                        <h3 class="mb-3 fw-semibold mb-5">Pendaftaran UKom Promosi</h3>
                        <hr>
                    </div>
                    <form method="POST" action="{{ route('/ukom/promosi/store') }}" enctype="multipart/form-data">
                        <div class="row g-lg-5 g-4">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <label for=""><span class="text-danger fw-bold">*</span>Periode UKom</label>
                                    <select
                                        class="js-example-basic-single @error('ukom_periode_id') is-invalid @enderror form-control"
                                        name="ukom_periode_id">
                                        <option value="" {{ old('ukom_periode_id') == '' ? 'selected' : '' }}>
                                            Pilih Periode
                                        </option>
                                        @if (isset($ukomPeriodeList))
                                            @foreach ($ukomPeriodeList as $index => $ukomPeriode)
                                                <option value="{{ $ukomPeriode->id }}">
                                                    {{ date('F Y', strtotime($ukomPeriode->periode)) }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('ukom_periode_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for=""><span class="text-danger fw-bold">*</span>
                                        Status Pendaftaran
                                    </label>
                                    <select class="js-example-basic-single @error('type') is-invalid @enderror form-control"
                                        name="type">
                                        <option selected value="baru">BARU</option>
                                        <option value="mengulang">Mengulang</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <hr class="bg-primary" style="border: none; height: 5px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">
                                            <span class="text-danger fw-bold">*</span>NIP
                                        </label>
                                        <input type="number" class="form-control" id="nip" name="nip"
                                            oninput="limitLength(this, 18)">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nama
                                        </label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Email
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jenis Kelamin
                                        </label>
                                        <select class="js-example-basic-single" name="jenis_kelamin" id="jenis_kelamin">
                                            <option selected>Pilih Jenis Kelamin</option>
                                            <option value="Pria">Pria</option>
                                            <option value="Wanita">Wanita</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="pendidikan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Pendidikan Terakhir
                                        </label>
                                        <select class="js-example-basic-single" name="pendidikan" id="pendidikan">
                                            <option selected>Pilih Pendidikan Terakhir</option>
                                            <option value="SMA">SMA</option>
                                            <option value="D3">D3</option>
                                            <option value="D4/S1">D4/S1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Program Studi
                                        </label>
                                        <input type="text" class="form-control" id="jurusan" name="jurusan">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <hr class="bg-primary" style="border: none; height: 5px;">
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Instansi
                                        </label>
                                        <select
                                            class="js-example-basic-single @error('instansi_id') is-invalid @enderror form-control"
                                            name="instansi_id">
                                            <option value="" {{ old('instansi_id') == '' ? 'selected' : '' }}>
                                                Pilih Instansi
                                            </option>
                                            @if (isset($instansiList))
                                                @foreach ($instansiList as $index => $instansi)
                                                    <option value="{{ $instansi->id }}">
                                                        {{ $instansi->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('instansi_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Unit Kerja/Instansi Daerah
                                        </label>
                                        <select
                                            class="js-example-basic-single @error('unit_kerja_id') is-invalid @enderror form-control"
                                            name="unit_kerja_id">
                                            <option value="" {{ old('unit_kerja_id') == '' ? 'selected' : '' }}>
                                                Pilih Unit Kerja/Instansi Daerah
                                            </option>
                                            @if (isset($unitKerjaList))
                                                @foreach ($unitKerjaList as $index => $unitKerja)
                                                    <option value="{{ $unitKerja->id }}">
                                                        {{ $unitKerja->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('unit_kerja_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="karpeg" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Nomor Kartu Pegawai
                                        </label>
                                        <input type="text" class="form-control" id="karpeg" name="karpeg"
                                            maxlength="10" oninput="validateLength(this)">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_cpns" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMT CPNS
                                        </label>
                                        <input type="date" data-provider="flatpickr" class="form-control"
                                            id="tmt_cpns" name="tmt_cpns">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="jabatan_name" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jabatan
                                        </label>
                                        <input type="text" class="form-control" id="jabatan_name"
                                            name="jabatan_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_jabatan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMT Jabatan
                                        </label>
                                        <input type="date" data-provider="flatpickr" class="form-control"
                                            id="tmt_jabatan" name="tmt_jabatan">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Tujuan Jabatan
                                        </label>
                                        <select
                                            class="js-example-basic-single @error('tujuan_jabatan_code') is-invalid @enderror form-control"
                                            name="tujuan_jabatan_code">
                                            <option value=""
                                                {{ old('tujuan_jabatan_code') == '' ? 'selected' : '' }}>
                                                Pilih Jabatan
                                            </option>
                                            @if (isset($jabatanList))
                                                @foreach ($jabatanList as $index => $jabatan)
                                                    <option value="{{ $jabatan->code }}">
                                                        {{ $jabatan->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('tujuan_jabatan_code')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="">
                                            <span class="text-danger fw-bold">*</span> Pangkat
                                        </label>
                                        <select
                                            class="js-example-basic-single @error('pangkat_id') is-invalid @enderror form-control"
                                            name="pangkat_id">
                                            <option value="" {{ old('pangkat_id') == '' ? 'selected' : '' }}>
                                                Pilih Pangkat
                                            </option>
                                            @if (isset($pangkatList))
                                                @foreach ($pangkatList as $index => $pangkat)
                                                    <option value="{{ $pangkat->id }}">
                                                        {{ $pangkat->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('pangkat_id')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="tmt_pangkat" class="form-label">
                                            <span class="text-danger fw-bold">*</span> TMP Pangkat
                                        </label>
                                        <input type="date" data-provider="flatpickr" class="form-control"
                                            id="tmt_pangkat" name="tmt_pangkat">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary float-end">
                                    Ajukan <i class=" las la-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <footer class="custom-footer bg-dark py-5 position-relative">
            <div class="container">
                <div class="row">
                    {{-- <div class="col-lg-4 mt-4">
                        <div>
                            <div>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Logo_Kementerian_Perdagangan_Republik_Indonesia_%282021%29.svg"
                                    alt="" height="35">
                            </div>
                            <div class="mt-4 fs-13">
                                <p>Premium Multipurpose Admin & Dashboard Template</p>
                                <p class="ff-secondary">You can build any type of web application like eCommerce, CRM,
                                    CMS, Project management apps, Admin Panels, etc using SIjuPRI.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 ms-lg-auto">
                        <div class="row">
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Company</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list">
                                        <li><a href="pages-profile">About Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </footer>
        <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
    </div>
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
@endsection
