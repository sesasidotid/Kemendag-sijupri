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

        .outline-text {
            -webkit-text-stroke: 0.2px black;
            text-stroke: 0.2px black;
        }
    </style>
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    @include('dashboard.user.profil')
    <div class="row">
        <div class="col-md-4 position-relative">
            <a href="{{ route('/ukom/pendaftaran_ukom') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="lab lab la-wpforms align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran UKom</p>
                                <h4 class=" mb-0">
                                    <span>UKom</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i>
                                    <span></span>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
            @if ($ukomMessage)
                <div class="position-absolute top-0 end-0 mb-5">
                    <div class="alert alert-secondary text-secondary p-1" style="width: 200px; overflow: hidden;">
                        <div class="marquee">
                            <span class="outline-text">{{ $ukomMessage }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4 position-relative">
            <a href="{{ route('/akp/review') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="lab lab la-wpforms align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Review AKP</p>
                                <h4 class=" mb-0">
                                    <span>AKP</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i>
                                    <span></span>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
            @if ($akpMessage)
                <div class="position-absolute top-0 end-0 mb-5">
                    <div class="alert alert-secondary text-secondary p-1" style="width: 200px; overflow: hidden;">
                        <div class="marquee">
                            <span class="outline-text">{{ $akpMessage }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4 position-relative">
            <a href="{{ route('/pengumuman/daftar') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="las la-bullhorn align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Daftar Pengumuman</p>
                                <h4 class=" mb-0">
                                    <span>Pengumuman</span>
                                </h4>
                            </div>
                            <div class="flex-shrink-0 align-self-end">
                                <span class="badge bg-success-subtle text-success"><i
                                        class="ri-arrow-up-s-fill align-middle me-1"></i>
                                    <span></span>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div>
            </a>
        </div>
    </div>
@endsection
