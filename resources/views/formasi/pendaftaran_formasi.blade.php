@extends('layout.v_wrapper')
@section('title')
    Pendaftaran Formasi
@endsection
@push('ext_header')
    @include('layout.css_select')
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
    @include('layout.js_select')
@endpush
@section('content')
    <div class="col-lg-12">
        @if ($formasiDocument)
            @if (isset($formasiDocument->auditTimeline) &&
                    $formasiDocument->auditTimeline != null &&
                    count($formasiDocument->auditTimeline->toArray()) > 0)
                <div class="col-xxl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>Timeline Pengajuan Formasi</h4>
                            <hr>
                            <div class="col-lg-12">
                                @include('widget.timeline', [
                                    'timelineList' => $formasiDocument->auditTimeline,
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (!$formasiDocument->waktu_pelaksanaan && $formasiDocument->task_status == 'PENDING')
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <div class="flex-shrink-0 alert alert-primary w-100">
                            Silahkan Mendaftarkan Formasi sesuai Jabatan
                            <a href="{{ route('/formasi/pendaftaran_formasi/detail_dokumen') }}"
                                class="btn btn-sm btn-primary float-end">Ubah Dokumen</a>
                        </div>
                    </div>
                </div>
                <div class="outer-container">
                    <div class="row">
                        <div class="col-md-6 position-relative">
                            <a href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'penera']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Penera</span>
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
                            @if (isset($formasiPeneraMessage) && $formasiPeneraMessage)
                                <div class="position-absolute top-0 end-0 mb-5">
                                    <div class="alert alert-secondary text-secondary p-1"
                                        style="width: 200px; overflow: hidden;">
                                        <div class="marquee">
                                            <span class="outline-text">{{ $formasiPeneraMessage }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative">
                            <a
                                href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'pengamat_tera']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Pengamat Tera</span>
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
                            @if (isset($formasiPengamatTeraMessage) && $formasiPengamatTeraMessage)
                                <div class="position-absolute top-0 end-0 mb-5">
                                    <div class="alert alert-secondary text-secondary p-1"
                                        style="width: 200px; overflow: hidden;">
                                        <div class="marquee">
                                            <span class="outline-text">{{ $formasiPengamatTeraMessage }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative">
                            <a
                                href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'pengawas_kemetrologian']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Pengawas Kemetrologian</span>
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
                            @if (isset($formasiPengawasKemetrologianMessage) && $formasiPengawasKemetrologianMessage)
                                <div class="position-absolute top-0 end-0 mb-5">
                                    <div class="alert alert-secondary text-secondary p-1"
                                        style="width: 200px; overflow: hidden;">
                                        <div class="marquee">
                                            <span class="outline-text">{{ $formasiPengawasKemetrologianMessage }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative">
                            <a
                                href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'penguji_mutu_barang']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Penguji Mutu Barang</span>
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
                            @if (isset($formasiPengujiMutuBarangMessage) && $formasiPengujiMutuBarangMessage)
                                <div class="position-absolute top-0 end-0 mb-5">
                                    <div class="alert alert-secondary text-secondary p-1"
                                        style="width: 200px; overflow: hidden;">
                                        <div class="marquee">
                                            <span class="outline-text">{{ $formasiPengujiMutuBarangMessage }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative">
                            <a
                                href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'pengawas_perdagangan']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Pengawas Perdagangan</span>
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
                            @if (isset($formasiPengawasPerdaganganMessage) && $formasiPengawasPerdaganganMessage)
                                <div class="position-absolute top-0 end-0 mb-5">
                                    <div class="alert alert-secondary text-secondary p-1"
                                        style="width: 200px; overflow: hidden;">
                                        <div class="marquee">
                                            <span class="outline-text">{{ $formasiPengawasPerdaganganMessage }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 position-relative">
                            <a
                                href="{{ route('/formasi/pendaftaran_formasi/detail', ['jabatan_code' => 'analis_perdagangan']) }}">
                                <div class="card card-animate mt-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                    <i class="lab lab la-wpforms align-middle"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran
                                                    Formasi
                                                    Jabatan
                                                </p>
                                                <h4 class=" mb-0">
                                                    <span class="">Analis Perdagangan</span>
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
                                @if (isset($formasiAnalisPerdaganganMessage) && $formasiAnalisPerdaganganMessage)
                                    <div class="position-absolute top-0 end-0 mb-5">
                                        <div class="alert alert-secondary text-secondary p-1"
                                            style="width: 200px; overflow: hidden;">
                                            <div class="marquee">
                                                <span class="outline-text">{{ $formasiAnalisPerdaganganMessage }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            @elseif($formasiDocument->task_status == 'REJECT')
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <div class="flex-shrink-0 alert alert-primary w-100">
                            Silahkan Mendaftarkan Formasi sesuai Jabatan
                            <a href="{{ route('/formasi/pendaftaran_formasi/detail_dokumen') }}"
                                class="btn btn-sm btn-primary float-end">Ubah Dokumen</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('/formasi/pendaftaran_formasi/update', ['id' => $formasiDocument->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @foreach ($formasiDocument->storage as $index => $storage)
                                    @if ($storage->task_status !== 'APPROVE')
                                        <div class="col-md-12 mb-3">
                                            <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                                {{ $storage->name }}
                                                <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                            </label>
                                            <a class="btn btn-sm btn-soft-info"
                                                name="preview-button-storage[{{ $storage->id }}]"
                                                href="javascript:void(0);"
                                                onclick="previewModal({{ json_encode($storage->file) }}, {{ json_encode($storage->name) }})">
                                                Lihat
                                            </a>
                                            <input type="file" accept=".pdf"
                                                class="form-control @error('storage[{{ $storage->id }}]') is-invalid @enderror"
                                                name="storage[{{ $storage->id }}]" id="employeeName"
                                                value="{{ old('storage[' . $storage->id . ']') }}">
                                            @error('storage[{{ $storage->id }}]')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                @endforeach
                                <div>
                                    <button type="submit" class="btn btn-sm btn-soft-info float-end">Ubah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @else
            <div class="card">
                <div class="card-header">
                    <div class="flex-shrink-0 alert alert-primary w-100">
                        Parameter Data Dukung Formasi
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('/formasi/upload_dokumen') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @foreach ($filePersyaratan['values'] as $index => $file)
                                <div class="col-md-12 mb-3">
                                    <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                        {{ $file }}
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input type="file" accept=".pdf" class="form-control"
                                        name="{{ str_replace(' ', '_', strtolower($file)) }}"
                                        value="{{ old(str_replace(' ', '_', strtolower($file))) ?? '' }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="w-100">
                            <button type="submit" class="btn btn-sm btn-soft-success float-end">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @include('widget.modal-doc')
    </div>
@endsection
