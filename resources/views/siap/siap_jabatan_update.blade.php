@extends('layout.v_wrapper')
@section('title')
    Ubah Data Jabatan
@endsection
@push('ext_header')
    @include('layout.css_select')
@endpush
@push('ext_footer')
    @include('layout.js_select')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="card  ">
                <div class="card-header d-flex bg-body-tertiary">
                </div>
                <div class="card-body p-4">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('/siap/jabatan/update', ['id' => $userJabatan->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Jabatan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jabatan
                                        </label>
                                        <select name="jabatan_code" id="Jabatan" class="form-select" name="state">
                                            @if (isset($jabatanList))
                                                <div style="position: absolute ;  display: none; position: absolute;">
                                                    @foreach ($jabatanList as $item)
                                                        <option @if ($userJabatan->jabatan_code == $item->code) selected @endif
                                                            value="{{ $item->code }}">{{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="Jenjang" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Jenjang
                                        </label>
                                        <select name="jenjang_code" class=" form-select" id="Jenjang">
                                            @if (isset($jenjangList))
                                                @foreach ($jenjangList as $item)
                                                    <option @if ($userJabatan->jenjang_code == $item->code) selected @endif
                                                        value="{{ $item->code }}"> {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="TMT" class="form-label">
                                            <span class="text-danger fw-bold">*</span> Terhitung Mulai Tanggal
                                        </label>
                                        <input name="tmt" type="date" class="form-control" data-provider="flatpickr"
                                            id="TMT" value="{{ $userJabatan->tmt }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="FileSKJabatan" class="form-label">
                                            <span class="text-danger fw-bold">*</span> File SK Jabatan
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_sk_jabatan"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userJabatan->file_sk_jabatan) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_sk_jabatan" type="file" accept=".pdf" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-info">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('widget.modal-doc')
@endsection
