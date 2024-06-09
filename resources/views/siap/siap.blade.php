@extends('layout.v_wrapper')
@section('title')
    Pengajuan Data Profil
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
    <div class="row">
        <div class="col-md-12 ">
            <div class="card  ">
                <div class="card-header justify-content-center d-flex bg-body-tertiary">
                    <ul class=" nav font-25 nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#userDetail" role="tab">
                                <i class=" las la-user-alt"></i>
                                Data Diri
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#Pendidikan" role="tab">
                                <i class=" las la-user-graduate"></i>
                                Riwayat Pendidikan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Jabatan" role="tab">
                                <i class=" las la-sort-up"></i>
                                Riwayat Jabatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#Pangkat" role="tab">

                                <i class=" las la-star"></i>
                                Riwayat Pangkat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#PAK" role="tab">
                                <i class=" las la-chart-area"></i>
                                Riwayat Kinerja
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#kompetensi" role="tab">
                                <i class=" las la-chart-area"></i>
                                Riwayat Kompentesi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#sertifikasi" role="tab">
                                <i class=" las la-chart-area"></i>
                                Riwayat Sertifikasi
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="userDetail" role="tabpanel">
                            <div class="card-body d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-md-12 shadow-sm ">
                                        @include('siap.siap_detail')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="Pendidikan" role="tabpanel">
                            @if (isset($user->userDetail))
                                <div class="row">
                                    @include('siap.siap_pendidikan')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="Jabatan" role="tabpanel">
                            @if (isset($user->userDetail))
                                <div class="row">
                                    @include('siap.siap_jabatan')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="Pangkat" role="tabpanel">
                            @if (isset($user->userJabatan))
                                <div class="row">
                                    @include('siap.siap_pangkat')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="PAK" role="tabpanel">
                            @if (isset($user->userDetail))
                                <div class="row">
                                    @include('siap.siap_kinerja')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="kompetensi" role="tabpanel">
                            @if (isset($user->userDetail))
                                <div class="row">
                                    @include('siap.siap_kompetensi')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="sertifikasi" role="tabpanel">
                            @if (isset($user->userDetail))
                                <div class="row">
                                    @include('siap.siap_sertifikasi')
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    <strong>Mohon untuk mengisi <strong>data diri</strong> terlebih dahulu</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('widget.modal-doc')
@endsection
