@extends('layout.v_wrapper')
@section('title')
    Pendaftaran UKom
@endsection
@push('ext_header')
    @include('layout.css_select')
@endpush
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Silahkan Mendaftarkan UKom sesuai target Anda
                </div>
            </div>
            @if (isset($ukom) && $ukom != null)
                <div class="card-body">
                    @include('widget.timeline', ['timelineList' => $ukom->auditTimeline])
                </div>
            @endif
        </div>
        @if (isset($ukom) && $ukom !== null)
            @if ($ukom->task_status === 'REJECT')
                <div class="card-header align-items-center d-flex">
                    <div class="flex-shrink-0 alert alert-primary w-100">
                        Silahkan Mengupdate Pendaftaran Anda
                    </div>
                </div>
                <form method="POST" action="{{ route('/ukom/pendaftaran_ukom/perbaikan', ['id' => $ukom->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @foreach ($ukom->storage as $index => $storage)
                        @if ($storage->task_status !== 'APPROVE')
                            <div class="col-md-12 mb-3">
                                <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                    {{ $storage->name }}
                                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                </label>
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
                        <button type="submit" class="btn btn-primary float-end">
                            Simpan <i class=" las la-save"></i>
                        </button>
                    </div>
                </form>
            @endif
        @else
            <div class="outer-container">
                <div class="row">
                    <div class="col-md-6 position-relative">
                        <a href="{{ route('/ukom/kenaikan_jenjang') }}">
                            <div class="card card-animate mt-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                <i class="lab lab la-wpforms align-middle"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran UKom
                                            </p>
                                            <h4 class=" mb-0">
                                                <span class="">Kenaikan Jenjang</span>
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
                    <div class="col-md-6 position-relative">
                        <a href="{{ route('/ukom/perpindahan_jabatan') }}">
                            <div class="card card-animate mt-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-light text-secondary rounded-circle fs-3">
                                                <i class="lab lab la-wpforms align-middle"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Pendaftaran UKom
                                            </p>
                                            <h4 class=" mb-0">
                                                <span class="">Perpindahan Jabatan</span>
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
            </div>
        @endif
        @include('widget.modal-doc')
    </div>
@endsection
