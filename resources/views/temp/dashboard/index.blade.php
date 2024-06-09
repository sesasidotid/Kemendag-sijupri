@extends('layout.v_wrapper')
@section('content')
    <div class="row">
        <div class="col-xxl-5">
            <div class="d-flex flex-column h-100">
                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="alert alert-primary border-0 rounded-0 m-0 d-flex align-items-center"
                                    role="alert">
                                    <i data-feather="alert-triangle" class="text-primary me-2 icon-sm"></i>
                                    <div class="flex-grow-1 text-truncate">
                                        Selamat Datang Di Sistem Informasi Jabatan Fungsional
                                    </div>

                                </div>

                                <div class="row align-items-end">
                                    <div class="col-sm-8">
                                        <div class="p-3">
                                            <p class="fs-16 lh-base">Silahkan Lakukan <span class="fw-semibold">Virtual
                                                    Tour</span>, untuk Pengenalan Sistem <i class="mdi mdi-arrow-right"></i>
                                            </p>
                                            <div class="mt-3">
                                                <a href="pages-pricing" class="btn btn-secondary">Virtual Tour!</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="px-3">
                                            <img src="{{ asset('build/images/user-illustarator-2.png') }}" class="img-fluid"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-body-->
                        </div>
                    </div> <!-- end col-->
                </div>
                <div class="row">
                    @include('siap.dashboard.users')
                    @include('siap.dashboard.akp')
                    @include('siap.dashboard.ukom')
                    @include('siap.dashboard.formasi')
                </div>
                @include('siap.dashboard.provinsi')
            </div>
        </div>

    </div>
@endsection
