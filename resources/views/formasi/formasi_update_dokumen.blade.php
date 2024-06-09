@extends('layout.v_wrapper')
@section('title')
    Detail Parameter Dokumen Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.tables_s')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Parameter Dokumen Formasi
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
                            <div class="col-md-12 mb-3">
                                <label for="employeeName" class="form-label"><i class=" las la-file-alt"></i>
                                    {{ $storage->name }}
                                    <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                </label>
                                <a class="btn btn-sm btn-soft-info" name="preview-button-storage[{{ $storage->id }}]"
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
                        @endforeach
                    </div>
                    <div>
                        <button type="submit" class="btn btn-sm btn-soft-info float-end">Ubah</button>
                    </div>
                </form>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
