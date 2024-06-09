@extends('layout.v_wrapper')
@section('title')
    Data Formasi Unit Kerja/Instansi Daerah
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
                        <h3>Nama Instansi Daerah</h3>
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
                    <div class="flex-grow-1">
                        <h5>Penera</h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Formasi Awal
                                        </div>
                                        <form action="">
                                            <table class="table table-nowrap ">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Jenjang
                                                    </td>
                                                    <td> Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('pemula') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-label " style="font-size: 0.8rem">Terampil</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('terampil') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('mahir') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('penyelia') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('pertama') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('muda') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('madya') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenera->jenjangPembulatan('utama') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <div class="flex-grow-1">
                        <h5>ANALISIS PERDAGANGAN</h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Form untuk menambah <strong>Analis Perdagangan</strong>
                                            Klik
                                            tombol <b>Simpan</b> untuk menyimpan
                                        </div>
                                        <form action="">
                                            <table class="table table-nowrap ">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Jenjang
                                                    </td>
                                                    <td> Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('pemula') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-label "
                                                            style="font-size: 0.8rem">Terampil</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('terampil') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('mahir') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('penyelia') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('pertama') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('muda') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('madya') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiAndag->jenjangPembulatan('utama') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="flex-grow-1">
                        <h5>PENGAMAT TERA
                        </h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Formasi Awal
                                        </div>
                                        <form action="">
                                            <table class="table table-nowrap ">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Jenjang
                                                    </td>
                                                    <td> Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('pemula') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-label "
                                                            style="font-size: 0.8rem">Terampil</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('terampil') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('mahir') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('penyelia') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('pertama') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('muda') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('madya') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengTera->jenjangPembulatan('utama') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="flex-grow-1">
                        <h5>PENGAWAS KEMETROLOGIAN
                        </h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Formasi Awal
                                        </div>
                                        <form action="">
                                            <table class="table table-nowrap ">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Jenjang
                                                    </td>
                                                    <td> Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('pemula') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-label "
                                                            style="font-size: 0.8rem">Terampil</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('terampil') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('mahir') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('penyelia') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('pertama') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('muda') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('madya') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPengMetro->jenjangPembulatan('utama') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="flex-grow-1">
                        <h5>PENGAWAS PERDAGANGAN
                        </h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Formasi Awal
                                        </div>
                                        <form action="">
                                            <table class="table table-nowrap ">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Jenjang
                                                    </td>
                                                    <td> Bobot</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('pemula') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-label "
                                                            style="font-size: 0.8rem">Terampil</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('terampil') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('mahir') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('penyelia') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('pertama') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('muda') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('madya') }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                    </td>
                                                    <td> <input readonly disabled class="form-control form-control-sm"
                                                            type="text"
                                                            value="{{ $formasiPenDag->jenjangPembulatan('utama') }}">
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    <div class="flex-grow-1">
                        <h5>PENGUJI MUTU BARANG
                        </h5>
                        <div class="mt-5">
                            <div class="row ">

                                <div class="col-md-12">

                                    <div class="table-responsive table-card">
                                        <!-- Info Alert -->
                                        <div class="alert alert-info" role="alert">
                                            Di bawah ini merupakan Formasi Awal
                                        </div>
                                        <table class="table table-nowrap ">
                                            <tr class="fw-bold">
                                                <td>
                                                    Jenjang
                                                </td>
                                                <td> Bobot</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Pemula</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('pemula') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-label " style="font-size: 0.8rem">Terampil</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('terampil') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Mahir</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('mahir') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Penyelia</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('penyelia') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Pertama</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('pertama') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Muda</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('muda') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Madya</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('madya') }}">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="form-labe " style="font-size: 0.8rem">Utama</label>
                                                </td>
                                                <td> <input readonly disabled class="form-control form-control-sm"
                                                        type="text"
                                                        value="{{ $formasiPMB->jenjangPembulatan('utama') }}">
                                                </td>
                                            </tr>
                                        </table>
                                        <form method="POST" action="{{ route('formasi.verifikasi.pertama.create') }}">
                                            @csrf
                                            <div style="width: 50%">
                                                <label for="basiInput" class="form-label text-info h4">Verifikasi
                                                    Formasi</label>
                                                <select class="form-select mb-3" aria-label="Default select example"
                                                    name="task_status">
                                                    <option selected disabled>Verifikasi</option>
                                                    <option value="APPROVE">Terima</option>
                                                    <option value="REJECT">Tolak</option>
                                                </select>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-secondary">Simpan</button>
                                            </div>
                                        </form>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
