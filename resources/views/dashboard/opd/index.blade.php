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
@section('content')
    @include('dashboard.opd.profil')
    <div class="row">
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
        <div class="col-md-4 position-relative">
            <a href="{{ route('/formasi/pendaftaran_formasi') }}">
                <div class="card card-animate mt-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                    <i class="lab lab la-wpforms align-middle"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran Formasi</p>
                                <h4 class=" mb-0">
                                    <span>Formasi</span>
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
            @if ($formasiMessage)
                <div class="position-absolute top-0 end-0 mb-5">
                    <div class="alert alert-secondary text-secondary p-1" style="width: 200px; overflow: hidden;">
                        <div class="marquee">
                            <span class="outline-text">{{ $formasiMessage ?? '' }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-cemter">
                    <h6>Daftar Aktif Undangan Formasi</h6>
                </div>
                <div class="card-body">
                    <table class="main-table table table-bordered nowrap align-middle w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>waktu pelaksanaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($formasiDokumenList))
                                @php $count = 0; @endphp
                                @foreach ($formasiDokumenList as $index => $formasiDokumen)
                                    @if ($formasiDokumen->waktu_pelaksanaan != null && $formasiDokumen->file_surat_undangan)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                @if (!$formasiDokumen->inactive_flag)
                                                    <span class="badge bg-info">Dalam proses</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td class="row">
                                                <table>
                                                    <tr>
                                                        <td class="text-dark fw-normal">
                                                            {{ $formasiDokumen->waktu_pelaksanaan }}
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-sm btn-soft-primary"
                                                                href="javascript:void(0);"
                                                                onclick="previewModal({{ json_encode($formasiDokumen->file_surat_undangan) }}, 'Surat Undangan')">
                                                                Lihat
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    @include('widget.modal-doc')
                </div>
            </div>
        </div>
    </div>
@endsection
