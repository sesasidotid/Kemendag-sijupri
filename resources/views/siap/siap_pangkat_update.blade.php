@extends('layout.v_wrapper')
@section('title')
    Ubah Data Pankat
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
                        <form method="POST" action="{{ route('/siap/pangkat/update', ['id' => $userPangkat->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="TMT" class="form-label">
                                            Terhitung Mulai Tanggal
                                        </label>
                                        <input name="tmt" type="date" data-provider="flatpickr" class="form-control"
                                            id="TMT" value="{{ $userPangkat->tmt }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="Pangkat" class="form-label">
                                            Pangkat
                                        </label>
                                        <select name="pangkat_id" class="form-select mb-3" aria-label="Pangkat"
                                            id="Pangkat">
                                            @if (isset($pangkatList))
                                                @foreach ($pangkatList as $item)
                                                    <option @if ($userPangkat->pangkat_id == $item->id) selected @endif
                                                        value="{{ $item->id }}">
                                                        {{ $item->description }}/{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="FileSKPangkat" class="form-label">
                                            File SK Pangkat
                                            <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                        </label>
                                        <a class="btn btn-sm btn-soft-info" name="preview-button-file_sk_pangkat"
                                            href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($userPangkat->file_sk_pangkat) }}, 'Ijazah')">
                                            Lihat
                                        </a>
                                        <input name="file_sk_pangkat" type="file" accept=".pdf" class="form-control"
                                            id="FileSKPangkat" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-sm btn-info">Ubah</button>
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
