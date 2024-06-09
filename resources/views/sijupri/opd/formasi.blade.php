@extends('layout.v_wrapper')
@section('title')
    Data Unit Kerja/Instansi Daerah
@endsection
@push('ext_header')
    @include('layout.css_select')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_select')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="bg-primary-subtle">
                <div class="card-body p-5">
                    <div class="text-center">
                        <h3>Nama Unit Kerja/Instansi Daerah</h3>
                        <p class="mb-0 text-muted">Last update: 16 Sept, 2022</p>
                    </div>
                </div>
                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none"
                        viewBox="0 0 1440 60">
                        <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                            <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z"
                                style="fill: var(--vz-secondary-bg);"></path>
                        </g>
                        <defs>
                            <mask id="SvgjsMask1001">
                                <rect width="1440" height="60" fill="#ffffff"></rect>
                            </mask>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiPenera == null || $formasiPenera->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>Penera</h5>
                            <div class="mt-5">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info" role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong></strong> Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code" value="penera">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>Jenjang</td>
                                                        <td>Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiPenera == null ? '' : $formasiPenera->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex mt-4">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiAndag == null || $formasiAndag->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>ANALISIS PERDAGANGAN</h5>
                            <div class="mt-5">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info" role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong>Analis
                                                    Perdagangan</strong>
                                                Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code"
                                                    value="analis_perdagangan">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>
                                                            Jenjang
                                                        </td>
                                                        <td> Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiAndag == null ? '' : $formasiAndag->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiPengTera == null || $formasiPengTera->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>PENGAMAT TERA
                            </h5>
                            <div class="mt-5">
                                <div class="row ">
                                    <div class="col-md-12">

                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info" role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong>Pengamat Tera.</strong>
                                                Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code" value="pengamat_tera">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>
                                                            Jenjang
                                                        </td>
                                                        <td> Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiPengTera == null ? '' : $formasiPengTera->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiPengMetro == null || $formasiPengMetro->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>PENGAWAS KEMETROLOGIAN
                            </h5>
                            <div class="mt-5">
                                <div class="row ">

                                    <div class="col-md-12">

                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info " role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong>Formasi PENGAWAS
                                                    KEMETROLOGIAN.</strong> Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code"
                                                    value="pengawas_kemetrologian">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>
                                                            Jenjang
                                                        </td>
                                                        <td> Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiPengMetro == null ? '' : $formasiPengMetro->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiPenDag == null || $formasiPenDag->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>PENGAWAS PERDAGANGAN
                            </h5>
                            <div class="mt-5">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info" role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong>Formasi awal PENGAWAS
                                                    PERDAGANGAN
                                                    .</strong> Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code"
                                                    value="pengawas_perdagangan">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>
                                                            Jenjang
                                                        </td>
                                                        <td> Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiPenDag == null ? '' : $formasiPenDag->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="feather feather-check-circle text-success icon-dual-success icon-xs">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    @if ($formasiPMB == null || $formasiPMB->task_status != 'APPROVE')
                        <div class="flex-grow-1">
                            <h5>PENGUJI MUTU BARANG
                            </h5>
                            <div class="mt-5">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="table-responsive table-card">
                                            <!-- Info Alert -->
                                            <div class="alert alert-info" role="alert">
                                                Di bawah ini merupakan Form untuk menambah <strong>Formasi Awal PENGUJI MUTU
                                                    BARANG.</strong> Klik
                                                tombol <b>Simpan</b> untuk menyimpan
                                            </div>
                                            <form method="POST" action="{{ route('siap.unit_kerja.formasi_utama') }}">
                                                @csrf
                                                <input hidden type="text" name="unit_kerja_id"
                                                    value="{{ $id }}">
                                                <input hidden type="text" name="jabatan_code"
                                                    value="penguji_mutu_barang">
                                                <table class="table table-nowrap ">
                                                    <tr class="fw-bold">
                                                        <td>
                                                            Jenjang
                                                        </td>
                                                        <td> Jumlah Kebutuhan</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pemula</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pemula]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('pemula') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Terampil</label>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[terampil]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('terampil') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Mahir</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[mahir]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('mahir') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Penyelia</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[penyelia]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('penyelia') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Pertama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[pertama]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('pertama') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label" style="font-size: 0.8rem">Muda</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[muda]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('muda') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Madya</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[madya]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('madya') }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="form-label"
                                                                style="font-size: 0.8rem">Utama</label>
                                                        </td>
                                                        <td><input class="form-control form-control-sm" type="text"
                                                                name="pembulatan[utama]"
                                                                value="{{ $formasiPMB == null ? '' : $formasiPMB->jenjangPembulatan('utama') }}">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-secondary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
