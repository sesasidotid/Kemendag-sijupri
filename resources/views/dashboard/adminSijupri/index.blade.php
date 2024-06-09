@extends('layout.v_wrapper')
@section('title')
    Dashboard
@endsection
@push('ext_header')
    @include('layout.css_tables')
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .marquee {
            animation: marquee 10s linear infinite;
            white-space: nowrap;
            display: inline-block;
        }
    </style>
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    @include('dashboard.user.profil_v2')
    <div class="row">
        <div class="col-md-4 position-relative">
            <a href="{{ route('/security/user') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="mdi mdi-account align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Admin Sijupri</p>
                                <h4 class=" mb-0">
                                    <span class="counter-value" data-target="{{ $adminCounts }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i><span>
                                    </span></span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
        </div>
        <div class="col-md-4 position-relative">
            <a href="{{ route('/user/admin_instansi') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="mdi mdi-account align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Admin Instansi</p>
                                <h4 class=" mb-0">
                                    <span class="counter-value" data-target="{{ $instansiCounts }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i><span>
                                    </span></span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
        </div>
        <div class="col-md-4 position-relative">
            <a href="{{ route('/user/admin_unit_kerja_instansi_daerah') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="mdi mdi-account align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Admin Unit Kerja/Instansi Daerah
                                </p>
                                <h4 class=" mb-0">
                                    <span class="counter-value" data-target="{{ $pengelolaCounts }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i><span>
                                    </span></span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
        </div>
        <div class="col-md-4 position-relative">
            <a href="{{ route('/user/user_jf') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="mdi mdi-account align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">User JF</p>
                                <h4 class=" mb-0">
                                    <span class="counter-value" data-target="{{ $userCounts }}">0</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i><span>
                                    </span></span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
        </div>
    </div>
    <hr>
@endsection
