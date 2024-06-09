@extends('layout.v_wrapper')
@section('title')
    Proses Verifikasi Dokumen
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
                    Daftar Proses Verifikasi Dokumen
                </div>
            </div>
            <div class="card-body">
                <table class="main-table">
                    <thead>
                        <tr>
                            <th>Undangan Verifikasi</th>
                            <th>Surat Undangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($formasiDocumentList)
                            @foreach ($formasiDocumentList as $index => $formasiDocument)
                                <tr>
                                    <td>{{ $formasiDocument->waktu_pelaksanaan }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-soft-primary" href="javascript:void(0);"
                                            onclick="previewModal({{ json_encode($formasiDocument->file_surat_undangan) }}, 'Surat Undangan')">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @include('widget.modal-doc')
            </div>
        </div>
    </div>
@endsection
