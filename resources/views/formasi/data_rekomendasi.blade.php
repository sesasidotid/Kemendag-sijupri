@extends('layout.v_wrapper')
@section('title')
    Data Rekomendasi & Formasi
@endsection
@push('ext_header')
    @include('layout.css_tables')
@endpush
@push('ext_footer')
    @include('layout.js_tables')
@endpush
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <div class="flex-shrink-0 alert alert-primary w-100">
                    Data Unit Kerja/Instansi & Rekomendasi Formasi
                </div>
            </div>
            <div class="row card-body">
                <div class="col">
                    <form method="POST"
                        action="{{ route('/formasi/data_rekomendasi_formasi/upload_rekomendasi/store', ['unit_kerja_id' => $unitKerja->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="FileRekomendasi" class="form-label">
                                        <span class="text-danger fw-bold">*</span>
                                        File Rekomendasi
                                        <strong class="text-info">(file: pdf | max: 2mb)</strong>
                                    </label>
                                    <input name="file_rekomendasi_formasi" type="file" accept=".pdf"
                                        class="form-control" id="FileRekomendasi" />
                                </div>
                            </div>
                            {{-- <div class="col-lg-12">
                                <table>
                                    @foreach ($formasiList as $index => $formasi)
                                        <tr>
                                            <td class="pe-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $formasi->id }}" id="flexCheckChecked{{ $formasi->id }}"
                                                        checked name="formasi[{{ $index }}]">
                                                    <label class="form-check-label"
                                                        for="flexCheckChecked{{ $formasi->id }}">
                                                        {{ $formasi->jabatan->name }}
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="" class="btn btn-sm btn-soft-info">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div> --}}
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-sm float-end m-1">
                                    Kirim Rekomendasi Formasi
                                </button>
                            </div>
                            <hr>
                            <div class="col-12 bg-light">
                                @if (isset($unitKerja->file_rekomendasi_formasi) && $unitKerja->file_rekomendasi_formasi)
                                    <iframe id="previewIframe" width="100%" height="600px"
                                        src="{{ asset($unitKerja->file_rekomendasi_formasi ? 'storage/' . $unitKerja->file_rekomendasi_formasi : 'Rekomendasi Formasi') }}">
                                    </iframe>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="col bg-light">
                    @if (isset($unitKerja->file_rekomendasi_formasi) && $unitKerja->file_rekomendasi_formasi)
                        <iframe id="previewIframe" width="100%" height="600px"
                            src="{{ asset($unitKerja->file_rekomendasi_formasi ? 'storage/' . $unitKerja->file_rekomendasi_formasi : 'Rekomendasi Formasi') }}">
                        </iframe>
                    @endif
                </div> --}}
            </div>
            @include('widget.modal-doc')
        </div>
    </div>
@endsection
